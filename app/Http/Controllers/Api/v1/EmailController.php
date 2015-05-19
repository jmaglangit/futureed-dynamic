<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ApiValidatorTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class EmailController extends ApiController {

	public function checkEmail(){
        $input = Input::only('email','user_type');

        //get email return user_id
        //else error message not exist.
        $email = $input['email'];
        $user_type = $input['user_type'];

        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->userType($input,'user_type'));

        $msg_bag = $this->getMessageBag();

        if(!empty($msg_bag)){

            return $this->respondWithError($this->getMessageBag());
        }

        $return =  $this->user->checkEmail($email,$user_type);

        if(!$return){

            return $this->respondErrorMessage(2002);

        }elseif($input['user_type'] == 'Student'){

            $return['user_id'] = $this->student->getStudentId($return['user_id']);

        }

        return $this->respondWithData(['id'=>$return['user_id']]);
    }



    public function updateStudentEmail($id){

        $userType = config('futureed.student');

        $input = Input::only('new_email','password_image_id','callback_uri');

        $this->addMessageBag($this->validateVarNumber($id));
        $this->addMessageBag($this->email($input,'new_email')); 
        $this->addMessageBag($this->validateNumber($input,'password_image_id'));
        $this->addMessageBag($this->validateString($input,'callback_uri'));

        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            $idExist = $this->student->checkIdExist($id);

            if($idExist){


                $studentReferences = $this->student->getStudentReferences($id);
                $userDetails = $this->user->getUserDetail($studentReferences['user_id'],$userType);
                $checkEmailExist = $this->user->checkEmail($input['new_email'],$userType);


                if($studentReferences['password_image_id'] != $input['password_image_id']){

                  return $this->respondErrorMessage(2012);

                }else if($userDetails['email'] == $input['new_email']){

                  return $this->respondErrorMessage(2107); 

                }else if($checkEmailExist){

                  return $this->respondErrorMessage(2200);

                }else{

                    $code = $this->code->getCodeExpiry();
                    $this->user->addNewEmail($studentReferences['user_id'],$input['new_email']);

                    $new_user_details = $this->user->getUserDetail($studentReferences['user_id'],$userType);
                    $this->mail->sendMailChangeEmail($new_user_details,$code['confirmation_code'],$input['callback_uri'],0);
                    $this->user->updateEmailCode($studentReferences['user_id'],$code);
                    
                    return $this->respondWithData(['id' => $id]);

                }

            }else{

                return $this->respondErrorMessage(2001);

            }

        }

    }


    public function resendChangeEmail($id){
       
        $input = Input::only('user_type','callback_uri');

        $this->addMessageBag($this->userTypeClientStudent($input,'user_type'));
        $this->addMessageBag($this->validateString($input,'callback_uri'));
        $this->addMessageBag($this->validateVarNumber($id));

        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            if(strcasecmp($input['user_type'],config('futureed.student')) == 0){

                $id_exist = $this->student->getStudent($id);

            }

            if(strcasecmp($input['user_type'],config('futureed.client')) == 0){

                $id_exist = $this->client->verifyClientId($id);

            }


            if(empty($id_exist)){

                return $this->respondErrorMessage(2001);

            }else{

                $userDetails = $this->user->getUserDetail($id_exist['user_id'],$input['user_type']);

                if(empty($userDetails['email_code'])){

                    return $this->respondErrorMessage(2111);

                }else{

                    $code=$this->code->getCodeExpiry();

                    $this->user->updateEmailCode($id_exist['user_id'],$code);

                    $this->mail->sendMailChangeEmail($userDetails,$code['confirmation_code'],$input['callback_uri'],1);

                    return $this->respondWithData(['id' => $id]);

                }


            }

        }

    }

    public function confirmChangeEmail(){

        $input = Input::only('new_email','user_type','confirmation_code');

        $this->addMessageBag($this->email($input,'new_email'));
        $this->addMessageBag($this->userTypeClientStudent($input,'user_type'));
        $this->addMessageBag($this->validateNumber($input,'confirmation_code'));

        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            $user_id = $this->user->checkNewEmailExist($input['new_email'],$input['user_type']);

            if(empty($user_id)){

                return $this->respondErrorMessage(2108);
            }else{

                $user_details = $this->user->getUserDetail($user_id,$input['user_type']);

                $code_expire = $this->user->checkCodeExpiry($user_details['email_code_expiry']);


                if($user_details['email_code'] != $input['confirmation_code']){

                    return $this->respondErrorMessage(2006);

                }else if($code_expire){

                    return $this->respondErrorMessage(2007);

                }else{

                    $this->user->updateToNewEmail($user_id,$input['new_email']);

                    if(strcasecmp($input['user_type'],config('futureed.student')) == 0){
                        
                        $return = $this->student->getStudentId($user_details['id']);

                    }

                    if (strcasecmp($input['user_type'],config('futureed.client')) == 0){

                        $return = $this->client->getClientId($user_details['id']);

                    }

                    return $this->respondWithData(['id' => $return]);
                    
                }

            }



        }



    }


     public function updateClientEmail($id){

        $userType = config('futureed.client');

        $input = Input::only('new_email','password','callback_uri');

        $this->addMessageBag($this->validateVarNumber($id));
        $this->addMessageBag($this->email($input,'new_email')); 
        $this->addMessageBag($this->checkPassword($input,'password'));
        $this->addMessageBag($this->validateString($input,'callback_uri'));

        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            $idExist = $this->client->verifyClientId($id);

            if($idExist){

                $userDetails = $this->user->getUserDetail($idExist['user_id'],$userType);
                $checkEmailExist = $this->user->checkEmail($input['new_email'],$userType);

                $password = sha1($input['password']);

                if($userDetails['password'] != $password){

                  return $this->respondErrorMessage(2114);

                }else if($userDetails['email'] == $input['new_email']){

                  return $this->respondErrorMessage(2107); 

                }else if($checkEmailExist){

                  return $this->respondErrorMessage(2200);

                }else{

                    $code = $this->code->getCodeExpiry();
                    $this->user->addNewEmail($idExist['user_id'],$input['new_email']);

                    $new_user_details = $this->user->getUserDetail($idExist['user_id'],$userType);
                    $this->mail->sendMailChangeEmail($new_user_details,$code['confirmation_code'],$input['callback_uri'],0);
                    $this->user->updateEmailCode($idExist['user_id'],$code);
                    
                    return $this->respondWithData(['id' => $id]);

                }

            }else{

                return $this->respondErrorMessage(2001);

            }

        }

    }

    //it sents an email if the client is reviewed by admin 
    public function verifyClient($id){

        $userType = config('futureed.client');
        $input = Input::only('is_account_reviewed');
        $url = Input::only('callback_uri');



        $this->addMessageBag($this->validateVarNumber($id));
        $this->addMessageBag($this->isAccountReviewed($input,'is_account_reviewed'));
        $this->addMessageBag($this->validateString($url,'callback_uri'));


        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            $verify_client = $this->client->verifyClientId($id);

            if(!$verify_client){

                return $this->respondErrorMessage(2001);

            }else{

                $user_details = $this->user->getUserDetail($verify_client['user_id'],$userType);

                //this sends an email to if verify
                $this->mail->sendClientVerification($user_details,$url['callback_uri']);
                $this->client->updateClientDetails($id,$input);

                return $this->respondWithData(['id' => $id
                                             ]);
            }

        }


    }


     public function rejectClient($id){

        $userType = config('futureed.client');
        $input = Input::only('is_account_reviewed');
        $url = Input::only('callback_uri');



        $this->addMessageBag($this->validateVarNumber($id));
        $this->addMessageBag($this->isAccountReviewed($input,'is_account_reviewed'));
        $this->addMessageBag($this->validateString($url,'callback_uri'));


        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            $verify_client = $this->client->verifyClientId($id);

            if(!$verify_client){

                return $this->respondErrorMessage(2001);

            }else{

                $user_details = $this->user->getUserDetail($verify_client['user_id'],$userType);

                //this sends an email to if verify
                $this->mail->sendClientRejection($user_details,$url['callback_uri']);
                $this->client->updateClientDetails($id,$input);

                return $this->respondWithData(['id' => $id
                                             ]);
            }

        }


    }

}


