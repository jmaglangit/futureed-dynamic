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

        if(!$return){

            return $this->respondErrorMessage(2001);

        }elseif(strcasecmp($input['user_type'], config('futureed.student')) == 0){

            $return['id'] = $this->student->getStudentId($return['user_id']);

        }elseif(strcasecmp($input['user_type'], config('futureed.client')) == 0){

            $return['id'] = $this->client->getClientId($return['user_id']);

        }elseif(strcasecmp($input['user_type'], config('futureed.admin')) == 0){

            $return['id'] = $this->admin->getAdminId($return['user_id']);
        }

        return $this->respondWithData(['id'=>$return['id']]);

    }

    //confirmation of email code
    public function confirmEmailCode(){
        $input = Input::only('email','email_code','user_type');

        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->emailCode($input,'email_code'));
        $this->addMessageBag($this->userType($input,'user_type'));

        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }

        //confirm email code
        //check email
        $user_check = $this->user->checkEmail($input['email'],$input['user_type']);
        if(!$user_check){

            return $this->respondErrorMessage(2002);
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

        $client = config('futureed.client');
        $student = config('futureed.student');
        $admin = config('futureed.admin');

        if( strtolower($client) == strtolower($input['user_type'])) {

           //update is activate and is lock for client
           $this->user->updateInactiveLock($user_check['user_id']);

           $return = $this->client->getClientId($user_check['user_id']);

        }elseif( strtolower($student) == strtolower($input['user_type'])){
            
           $return = $this->student->getStudentId($user_check['user_id']);

        }else{

            //todo admin confirmation for admin.methods not yet made since where not on admin side.//

        }

        return $this->respondWithData([
            'id' => $return
        ]);

    }


    //resend reset email code 
    public function resendResetEmailCode(){

        $input = Input::only('email','user_type','callback_uri'); 
        $error = config('futureed-error.error_messages');
        $subject = config('futureed.subject_forgot_resend');

        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->userType($input,'user_type'));
        $this->addMessageBag($this->validateString($input,'callback_uri'));


        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            $return = $this->user->checkEmail($input['email'],$input['user_type']);


            if(!empty($return)){
                
                $userDetails = $this->user->getUserDetail($return['user_id'],$input['user_type']);


                if(empty($userDetails['reset_code'])){

                    return $this->respondErrorMessage(2110);

                }else{

                    $code=$this->code->getCodeExpiry();

                    $this->user->setResetCode($return['user_id'],$code);

                    if(strtolower($input['user_type']) == 'student'){

                        $student_id = $this->student->getStudentId($return['user_id']);


						$subject = str_replace('{user}',config('futureed.student'),$subject);

                        $this->mail->sendStudentMailResetPassword($userDetails,$code['confirmation_code'],$input['callback_uri'],$subject);

                        return $this->respondWithData(['id' => $student_id,
                                                       'user_type' => $input['user_type'] 
                                                     ]);

                    
                    }elseif(strtolower($input['user_type']) == 'client'){



                        $client_id = $this->client->getClientId($return['user_id']);

						//get client role
						$client_role = $this->client->getRole($return['user_id']);

						//change subject
						$subject = str_replace('{user}',$client_role,$subject);

                        $this->mail->sendClientMailResetPassword($userDetails,$code['confirmation_code'],$input['callback_uri'],$subject);

                        return $this->respondWithData(['id' => $client_id,
                                                       'user_type' => $input['user_type'] 
                                                     ]);
                        
                   
                    }else{

                        $admin_id = $this->admin->getAdminId($return['user_id']);

						$admin_detail = $this->admin->getAdmin($admin_id);

						$subject = str_replace('{user}',$admin_detail->admin_role,$subject);

                        $this->mail->sendAdminMailResetPassword($userDetails,$code['confirmation_code'],$input['callback_uri'],$subject);

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

    //resend registration email code 

    public function resendRegisterEmailCode(){

        $input = Input::only('email','user_type','callback_uri');
        $error = config('futureed-error.error_messages');
        $subject = config('futureed.subject_reg_resend');

        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->userTypeClientStudent($input,'user_type'));
        $this->addMessageBag($this->validateString($input,'callback_uri'));


        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        } else {

            $return = $this->user->checkEmail($input['email'], $input['user_type']);

            if(!empty($return)){

                $userDetails = $this->user->getUserDetail($return['user_id'], $input['user_type']);
                                
                if($userDetails['is_account_activated'] == config('futureed.activated')){

                   return $this->respondErrorMessage(2109);

                } else {

                    $code=$this->code->getCodeExpiry();

                    $this->user->updateConfirmationCode($return['user_id'],$code);


                    if(strtolower($input['user_type']) == 'student') {

                        $student_id = $this->student->getStudentId($return['user_id']);

						$subject = str_replace('{user}',config('futureed.student'),$subject);

                        $this->mail->resendStudentRegister($userDetails,$code['confirmation_code'],$input['callback_uri'],$subject);

                        return $this->respondWithData(['id' => $student_id,
                                                       'user_type' => $input['user_type'] 
                                                     ]);

                    
                    } else {

                        $client_id = $this->client->getClientId($return['user_id']);

                        $this->mail->sendClientRegister($userDetails,$code['confirmation_code'],$input['callback_uri'],1);

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



}
