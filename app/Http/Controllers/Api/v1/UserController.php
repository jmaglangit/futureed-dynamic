<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ApiValidatorTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Services\ClientServices;
use FutureEd\Services\StudentServices;
use FutureEd\Services\UserServices;
use FutureEd\Services\MailServices;
use FutureEd\Services\CodeGeneratorServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use FutureEd\Http\Requests\Api\UserRequest;

class UserController extends ApiController{

    protected $client_service;
    protected $client;
    protected $user_service;
    protected $student;
    protected $student_service;
    protected $admin;
    protected $code_service;
    protected $mail_service;
    protected $user;

    public function __construct(
        ClientRepositoryInterface $clientRepositoryInterface,
        ClientServices $clientServices,
        UserServices $userServices,
        StudentRepositoryInterface $studentRepositoryInterface,
        StudentServices $studentServices,
        AdminRepositoryInterface $adminRepositoryInterface,
        CodeGeneratorServices $codeGeneratorServices,
        MailServices $mailServices,
        UserRepositoryInterface $userRepositoryInterface
    ){
        $this->client_service = $clientServices;
        $this->client = $clientRepositoryInterface;
        $this->user_service = $userServices;
        $this->student_service = $studentServices;
        $this->student = $studentRepositoryInterface;
        $this->admin = $adminRepositoryInterface;
        $this->code_service = $codeGeneratorServices;
        $this->mail_service = $mailServices;
        $this->user = $userRepositoryInterface;
    }

    /**
     * check user if it exists.
     * @return mixed
     */
    public function checkUser(){
        $input = Input::only('username','user_type');

        //get email return user_id
        //else error message not exist.
        $username = $input['username'];
        $user_type = $input['user_type'];

        $this->addMessageBag($this->username($input,'username'));
        $this->addMessageBag($this->userType($input,'user_type'));

        $msg_bag = $this->getMessageBag();

        if(!empty($msg_bag)){

            return $this->respondWithError($this->getMessageBag());
        }

        $return =  $this->user_service->checkUsername($username,$user_type);

        if(!$return){

            return $this->respondErrorMessage(2001);

        }elseif(strcasecmp($input['user_type'], config('futureed.student')) == 0){

            $return['id'] = $this->student->getStudentId($return['user_id']);

        }elseif(strcasecmp($input['user_type'], config('futureed.client')) == 0){

            $return['id'] = $this->client_service->getClientId($return['user_id']);

        }elseif(strcasecmp($input['user_type'], config('futureed.admin')) == 0){

            $return['id'] = $this->admin->getAdminId($return['user_id']);
        }

        return $this->respondWithData(['id'=>$return['id']]);

    }

    /**
     * confirmation for email and code.
     * @param UserRequest $request
     * @return mixed
     */
    public function confirmEmailCode(UserRequest $request){

        $input = $request->only('email','email_code','user_type');

        //get user details.
        $user_check = $this->user_service->checkEmail($input['email'],$input['user_type']);

        //get user detail
        $user_detail = $this->user_service->getUserDetail($user_check['user_id'],$input['user_type']);

        //check user if account is already activated
        if($user_detail['is_account_activated'] == config('futureed.activated')){

            return $this->respondErrorMessage(2109);
        }

        if($input['email_code'] <> $user_detail['confirmation_code']){

            return $this->respondErrorMessage(2006);
        }

        $code_expire = $this->user_service->checkCodeExpiry($user_detail['confirmation_code_expiry']);
        if($code_expire){

            return $this->respondErrorMessage(2007);
        }

        $client = config('futureed.client');
        $student = config('futureed.student');
        $admin = config('futureed.admin');

        if( strtolower($client) == strtolower($input['user_type'])) {
            if(!empty($user_detail['password'])){
                // //update is activate and is lock for client
                $this->user_service->updateInactiveLock($user_check['user_id']);
            }

            //Remove session_token
            $this->user_service->emptySession($user_check['user_id']);

            $return  = $this->client->getClient($user_check['user_id']);

            //output for client -- id, first_name, last_name, country_id, role for auto login
            return $this->respondWithData($return->toArray());

        }elseif( strtolower($student) == strtolower($input['user_type'])){
            
            $return = $this->student->getStudentByUserId($user_check['user_id']);

            return $this->respondWithData($return->toArray());

        }else{

            //todo admin confirmation for admin.methods not yet made since where not on admin side.//
            $return = 0;
        }

        return $this->respondWithData([
            'id' => $return
        ]);

    }

    /**
     * resend reset email code.
     * @return mixed
     */
    public function resendResetEmailCode(){

        $input = Input::only('email','user_type','callback_uri'); 
        $subject = config('futureed.subject_forgot_resend');

        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->userType($input,'user_type'));
        $this->addMessageBag($this->validateString($input,'callback_uri'));


        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            $return = $this->user_service->checkEmail($input['email'],$input['user_type']);


            if(!empty($return)){
                
                $userDetails = $this->user_service->getUserDetail($return['user_id'],$input['user_type']);


                if(empty($userDetails['reset_code'])){

                    return $this->respondErrorMessage(2110);

                }else{

                    $code=$this->code_service->getCodeExpiry();

                    $this->user_service->setResetCode($return['user_id'],$code);

                    if(strtolower($input['user_type']) == 'student'){

						$student_id = $this->student->getStudentId($return['user_id']);


						$subject = str_replace('{user}', config('futureed.student'), $subject);

						$this->mail_service->sendStudentMailResetPassword($userDetails, $code['confirmation_code'], $input['callback_uri'], $subject);

						return $this->respondWithData(['id' => $student_id,
							'user_type' => $input['user_type']
						]);

                    
                    }elseif(strtolower($input['user_type']) == 'client'){


						$client_id = $this->client_service->getClientId($return['user_id']);

						//get client role
						$client_role = $this->client_service->getRole($return['user_id']);

						//change subject
						$subject = str_replace('{user}', $client_role, $subject);

						$this->mail_service->sendClientMailResetPassword($userDetails, $code['confirmation_code'], $input['callback_uri'], $subject);

						return $this->respondWithData(['id' => $client_id,
							'user_type' => $input['user_type']
						]);
                        
                   
                    }else{

						$admin_id = $this->admin->getAdminId($return['user_id']);

						$admin_detail = $this->admin->getAdminDetail($admin_id);

						$subject = str_replace('{user}', $admin_detail->admin_role, $subject);

						$this->mail_service->sendAdminMailResetPassword($userDetails, $code['confirmation_code'], $input['callback_uri'], $subject);

						return $this->respondWithData(['id' => $admin_id,
							'user_type' => $input['user_type']
						]);
                    }


                }

               
            }else{
                
                return $this->respondErrorMessage(2002);
            }

        }

    }

    /**
     * resend registration email code.
     * @return mixed
     */
    public function resendRegisterEmailCode(){

        $input = Input::only('email','user_type','callback_uri');
        $subject = config('futureed.subject_reg_resend');

        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->userTypeClientStudent($input,'user_type'));
        $this->addMessageBag($this->validateString($input,'callback_uri'));


        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        } else {

            $return = $this->user_service->checkEmail($input['email'], $input['user_type']);

            if(!empty($return)){

                $userDetails = $this->user_service->getUserDetail($return['user_id'], $input['user_type']);
                                
                if($userDetails['is_account_activated'] == config('futureed.activated')){

                   return $this->respondErrorMessage(2109);

                } else {

                    $code=$this->code_service->getCodeExpiry();

                    $this->user_service->updateConfirmationCode($return['user_id'],$code);


                    if(strtolower($input['user_type']) == 'student') {

						$student_id = $this->student->getStudentId($return['user_id']);

						$subject = str_replace('{user}', config('futureed.student'), $subject);

						$this->mail_service->resendStudentRegister($userDetails, $code['confirmation_code'], $input['callback_uri'], $subject);

						return $this->respondWithData(['id' => $student_id,
							'user_type' => $input['user_type']
						]);

                    
                    } else {

                        $client_id = $this->client_service->getClientId($return['user_id']);

                        $this->mail_service->sendClientRegister($userDetails,$code['confirmation_code'],$input['callback_uri'],1);

                        return $this->respondWithData(['id' => $client_id,
                                                       'user_type' => $input['user_type'] 
                                                     ]);
                        
                    }
                    

                }

            } else {

                return $this->respondErrorMessage(2002);
            }
        }
    }

    /**
     * Logout user by user_type
     * @param UserRequest $request
     * @return mixed
     */
    public function logout(UserRequest $request){

        //logout
        //input id, user_type
        //get token and and update user token to null

        $id = $request->get('id');
        $user_type = $request->get('user_type');
        $user = new \stdClass();

        switch($user_type){

            case config('futureed.student'):

                $user = $this->student->getStudent($id);
                //get user_id of student
                break;
            case config('futureed.client'):

                //get user_id of client
                $user = $this->client_service->getClientDetails($id);

                break;
            case config('futureed.admin'):

                //get user_id of admin
                $user = $this->admin->getAdminDetail($id);
                break;

            default:

                break;
        }

       //empty session in user table and boolean.
        return ($this->user_service->emptySession($user->user_id))
            ? $this->respondWithData(true) : $this->respondWithData(false);
    }

    /**
     * Get Curriculum Country
     * @param $user_id
     * @return mixed
     */
    public function checkCurriculumCountry($user_id){

        //check user
        if(empty($this->user->getUser($user_id))){
            return $this->respondErrorMessage(2001);
        }

        return $this->respondWithData($this->user->getCurriculumCountry($user_id));
    }
}
