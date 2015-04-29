<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ApiValidatorTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Services\UserServices;
use FutureEd\Services\MailServices;
use FutureEd\Services\CodeGeneratorServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserController extends ApiController{

    //check user if exist
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

        $return =  $this->user->checkUsername($username,$user_type);
        


        if(isset($return['error_code'])){

            return $this->respondWithError($return);

        }elseif($input['user_type'] == 'Student'){

            $return['user_id'] = $this->student->getStudentId($return['user_id']);

        }

        return $this->respondWithData(['id'=>$return['user_id']]);

    }

    //confirmation of email code
    public function confirmEmailCode(){
        $input = Input::only('email','email_code','user_type');

        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->validateNumber($input,'email_code'));
        $this->addMessageBag($this->userType($input,'user_type'));

        if($this->getMessageBag()){

            return $this->respondWithData($this->getMessageBag());
        }

        //confirm email code
        //check email
        $user_check = $this->user->checkEmail($input['email'],$input['user_type']);
        if(isset($user_check['error_code'])){

            return $this->respondWithError($user_check);
        }

        //check code
        //get user detail
        $user_detail = $this->user->getUserDetail($user_check['user_id'],$input['user_type']);

        if($input['email_code'] <> $user_detail['confirmation_code']){

            return $this->respondErrorMessage(2006);
        }

        $code_expire = $this->user->checkCodeExpiry($user_detail['confirmation_code_expiry']);
        if($code_expire){

            return $this->respondErrorMessage(2007);
        }
        
        $return = $this->student->getStudentId($user_detail['id']);
        
        return $this->respondWithData([
            'id' => $return
        ]);

    }


    //resend reset email code 
    public function resendResetEmailCode(){

        $input = Input::only('email','user_type'); 
        $error = config('futureed-error.error_messages');
        $subject = config('futureed.subject_forgot_resend');

        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->userType($input,'user_type'));


        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            $return = $this->user->checkEmail($input['email'],$input['user_type']);


            if(array_key_exists('status',$return)){
                
                $userDetails = $this->user->getUserDetails($return['user_id']);

                $code=$this->code->getCodeExpiry();

                $this->user->setResetCode($return['user_id'],$code);

                if(strtolower($input['user_type']) == 'student'){

                    $student_id = $this->student->getStudentId($return['user_id']);

                    $this->mail->sendStudentMailResetPassword($userDetails,$code['confirmation_code'],$subject);

                    return $this->respondWithData(['id' => $student_id,
                                                   'user_type' => $input['user_type'] 
                                                 ]);

                
                }elseif(strtolower($input['user_type']) == 'client'){

                    $client_id = $this->client->getClientId($return['user_id']);

                    $this->mail->sendClientMailResetPassword($userDetails,$code['confirmation_code'],$subject);

                    return $this->respondWithData(['id' => $client_id,
                                                   'user_type' => $input['user_type'] 
                                                 ]);
                    
               
                }else{

                    $admin_id = $this->admin->getAdminId($return['user_id']);

                    $this->mail->sendAdminMailResetPassword($userDetails,$code['confirmation_code'],$subject);

                    return $this->respondWithData(['id' => $admin_id,
                                                   'user_type' => $input['user_type'] 
                                                 ]);
                }

            }else{
                
                return $this->respondErrorMessage(2002);
            }

        }

    }

    //resend registration email code 

    public function resendRegisterEmailCode(){

        $input = Input::only('email','user_type');
        $error = config('futureed-error.error_messages');
        $subject = config('futureed.subject_reg_resend');

        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->userTypeClientStudent($input,'user_type'));


        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            $return = $this->user->checkEmail($input['email'],$input['user_type']);

            if(array_key_exists('status',$return)){

                $userDetails = $this->user->getUser($return['user_id'],$input['user_type']);

                $code=$this->code->getCodeExpiry();

                $this->user->updateConfirmationCode($return['user_id'],$code);


                if(strtolower($input['user_type']) == 'student'){

                    $student_id = $this->student->getStudentId($return['user_id']);

                    $this->mail->resendStudentRegister($userDetails,$code['confirmation_code'],$subject);

                    return $this->respondWithData(['id' => $student_id,
                                                   'user_type' => $input['user_type'] 
                                                 ]);

                
                }else{

                    $client_id = $this->client->getClientId($return['user_id']);

                    $this->mail->sendClientRegister($userDetails,$code['confirmation_code'],$subject);

                    return $this->respondWithData(['id' => $client_id,
                                                   'user_type' => $input['user_type'] 
                                                 ]);
                    
               
                }

            }else{

                return $this->respondErrorMessage(2002);

            }

        }




    }



}
