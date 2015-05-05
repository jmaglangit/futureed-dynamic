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

        if(isset($return['error_code'])){

            return $this->respondWithError($return);

        }elseif($input['user_type'] == 'Student'){

            $return['user_id'] = $this->student->getStudentId($return['user_id']);

        }

        return $this->respondWithData(['id'=>$return['user_id']]);
    }



    public function updateStudentEmail($id){

        $userType = config('futureed.student');

        $input = Input::only('email','new_email','password_image_id');

        $this->addMessageBag($this->validateVarNumber($id));
        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->email($input,'new_email')); 
        $this->addMessageBag($this->validateNumber($input,'password_image_id'));

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

                }else if($userDetails['email'] != $input['email']){

                  return $this->respondErrorMessage(2106); 

                }else if($userDetails['email'] == $input['new_email']){

                  return $this->respondErrorMessage(2107); 

                }else if(array_key_exists('status',$checkEmailExist)){

                  return $this->respondErrorMessage(2200);

                }else{

                    $code = $this->code->getCodeExpiry();
                    $this->user->addNewEmail($studentReferences['user_id'],$input['new_email']);

                    $new_user_details = $this->user->getUserDetail($studentReferences['user_id'],$userType);
                    $this->mail->sendMailChangeEmail($new_user_details,$code['confirmation_code'],0);
                    $this->user->updateConfirmationCode($studentReferences['user_id'],$code);
                    

                    return $this->respondWithData(['id' => $id]);

                }

            }else{

                return $this->respondErrorMessage(2001);

            }

        }

    }


    public function resendChangeEmail(){

        $input = Input::only('new_email','user_type');

        $this->addMessageBag($this->email($input,'new_email'));
        $this->addMessageBag($this->userTypeClientStudent($input,'user_type'));


        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }else{

            $user_id = $this->user->checkNewEmailExist($input['new_email'],$input['user_type']);


            if(empty($user_id)){

                return $this->respondErrorMessage(2002);

            }else{

                $userDetails = $this->user->getUserDetail($user_id,$input['user_type']);

                $code=$this->code->getCodeExpiry();

                $this->user->updateConfirmationCode($user_id,$code);

                $student_id = $this->student->getStudentId($user_id);

                $this->mail->sendMailChangeEmail($userDetails,$code['confirmation_code'],1);

                return $this->respondWithData(['id' => $student_id]);

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

                return $this->respondErrorMessage(2002);
            }else{

                $user_details = $this->user->getUserDetail($user_id,$input['user_type']);
                $code_expire = $this->user->checkCodeExpiry($user_details['confirmation_code_expiry']);


                if($user_details['confirmation_code'] != $input['confirmation_code']){

                    return $this->respondErrorMessage(2006);

                }else if($code_expire){

                    return $this->respondErrorMessage(2007);

                }else{

                    $this->user->updateToNewEmail($user_id,$input['new_email']);
                    $return = $this->student->getStudentId($user_details['id']);

                    return $this->respondWithData(['id' => $return]);
                    
                }

            }



        }






    }

}
