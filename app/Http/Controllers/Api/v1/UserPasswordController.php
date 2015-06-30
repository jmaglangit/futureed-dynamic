<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\AccessTokenTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserPasswordController extends UserController {


    public function passwordForgot(){

		$input = Input::only('username', 'user_type', 'callback_uri');

		$this->addMessageBag($this->userType($input, 'user_type'));
		$this->addMessageBag($this->validateString($input, 'callback_uri'));
		$subject = config('futureed.subject_forgot');

		$flag = 0;

		if (!$this->email($input, 'username')) {

			$flag = 1;

		}
		if (!$this->username($input, 'username')) {

			$flag = 0;
		}


		if ($flag) {

			$this->addMessageBag($this->email($input, 'username'));

		} else {

			$this->addMessageBag($this->username($input, 'username'));

		}

		if ($this->getMessageBag()) {

			return $this->respondWithError($this->getMessageBag());

		} else {

			$return = $this->user->checkLoginName($input['username'], $input['user_type']);


			if ($this->valid->email($input['username'])) {

				$return = $this->user->checkEmail($input['username'], $input['user_type']);


			} elseif ($this->valid->username($input['username'])) {

				$return = $this->user->checkUserName($input['username'], $input['user_type']);

			}


			if (isset($return['status'])) {


				$userDetails = $this->user->getUserDetails($return['user_id']);

				$isActivated = $this->user->isActivated($return['user_id']);

				if ($isActivated == 1) {


					// get code
					$code = $this->code->getCodeExpiry();

					//update reset_code and expiry to db
					$this->user->setResetCode($return['user_id'], $code);


					if (strcasecmp($input['user_type'], config('futureed.student')) == 0) {

						$subject = str_replace('{user}', config('futureed.student'), $subject);

						$this->mail->sendStudentMailResetPassword($userDetails, $code['confirmation_code'], $input['callback_uri'], $subject);

					} elseif (strcasecmp($input['user_type'], config('futureed.client')) == 0) {

						$client_id = $this->client->getClientId($return['user_id']);

						$client = $this->client->getClientDetails($client_id);


						if ($client['account_status'] != config('futureed.client_account_status_accepted')) {

							return $this->respondErrorMessage(2013);
						}

						//update subject
						$subject = str_replace('{user}', $client->client_role, $subject);

						$subject = str_replace('{user}', config('futureed.client'), $subject);

						$this->mail->sendClientMailResetPassword($userDetails, $code['confirmation_code'], $input['callback_uri'], $subject);

					} else {

						$admin_id = $this->admin->getAdminId($return['user_id']);

						$admin = $this->admin->getAdmin($admin_id);

						//update subject
						$subject = str_replace('{user}', $admin->admin_role, $subject);

						$subject = str_replace('{user}', config('futureed.Admin'), $subject);

						$this->mail->sendAdminMailResetPassword($userDetails, $code['confirmation_code'], $input['callback_uri'], $subject);

					}

					return $this->respondWithData($userDetails->toArray());

				} else {

					return $this->respondErrorMessage(2018);

				}

			} else {

				return $this->respondErrorMessage(2018);
			}
		}

    }

    public function passwordReset(){


         
    }

    //confirmation of reset code
    public function confirmResetCode(){
      
       $input = Input::only('email','reset_code','user_type');
        $error = config('futureed-error.error_messages');

        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->resetCode($input,'reset_code'));
        $this->addMessageBag($this->userType($input,'user_type'));


         $msg_bag = $this->getMessageBag();

         if($msg_bag){

            return $this->respondWithError($this->getMessageBag());

         } else {
          
           $return=$this->user->getIdByEmail($input['email'],$input['user_type']);

          
           if($return['status']==202){
              
               return $this->respondErrorMessage(2001);
                        
           }else{

              $userdata = $this->user->getUserDetail($return['data'],$input['user_type']);
              
              if($userdata['reset_code']==$input['reset_code']){
                 
                  $expired=$this->user->checkCodeExpiry($userdata['reset_code_expiry']);
                 
                  if($expired==true){

                     return $this->respondErrorMessage(2100);
                     
                  }else{
                     
                      if(strcasecmp($input['user_type'],config('futureed.student')) == 0){

                        $studentdata = $this->student->resetCodeResponse($return['data']);
                        return $this->respondWithData($studentdata);

                      }elseif(strcasecmp($input['user_type'],config('futureed.client')) == 0){

                        $id = $this->client->getClientId($return['data']);
                        return $this->respondWithData(['id'=>$id]);

                     }else{

                        $id = $this->admin->getAdminId($return['data']);
                        return $this->respondWithData(['id'=>$id]);

                     }
                  }
              }else{
                 
                  return $this->respondErrorMessage(2100);
              }
                
           }

        }
    }


}
