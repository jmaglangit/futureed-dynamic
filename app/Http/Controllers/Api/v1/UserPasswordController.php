<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\UserPasswordRequest;
use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\Validator\ValidatorRepositoryInterface;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\MailServices;
use FutureEd\Services\UserServices;
use Illuminate\Support\Facades\Input;

class UserPasswordController extends UserController {

	protected $user_service;
	protected $validator;
	protected $code_generator_service;
	protected $admin;
	protected $mail_service;
	protected $client;
	protected $student;

	/**
	 * @param UserServices $userServices
	 * @param ValidatorRepositoryInterface $validatorRepositoryInterface
	 * @param CodeGeneratorServices $codeGeneratorServices
	 * @param AdminRepositoryInterface $adminRepositoryInterface
	 * @param MailServices $mailServices
	 * @param ClientRepositoryInterface $clientRepositoryInterface
	 * @param StudentRepositoryInterface $studentRepositoryInterface
	 */
	public function __construct(
		UserServices $userServices,
		ValidatorRepositoryInterface $validatorRepositoryInterface,
		CodeGeneratorServices $codeGeneratorServices,
		AdminRepositoryInterface $adminRepositoryInterface,
		MailServices $mailServices,
		ClientRepositoryInterface $clientRepositoryInterface,
		StudentRepositoryInterface $studentRepositoryInterface
	){
		$this->user_service = $userServices;
		$this->validator = $validatorRepositoryInterface;
		$this->code_generator_service = $codeGeneratorServices;
		$this->admin = $adminRepositoryInterface;
		$this->mail_service = $mailServices;
		$this->client = $clientRepositoryInterface;
		$this->student = $studentRepositoryInterface;
	}

	/**
	 * @param UserPasswordRequest $request
	 * @return mixed
	 */
    public function passwordForgot(UserPasswordRequest $request){

		$input = $request->only('username', 'user_type', 'callback_uri');

		$subject = config('futureed.subject_forgot');

		$return = $this->user_service->checkLoginName($input['username'], $input['user_type']);

		if ($this->validator->email($input['username'])) {

			$return = $this->user_service->checkEmail($input['username'], $input['user_type']);


		} elseif ($this->validator->username($input['username'])) {

			$return = $this->user_service->checkUserName($input['username'], $input['user_type']);

		}


		if (isset($return['status'])) {


			$userDetails = $this->user_service->getUserDetails($return['user_id']);

			$isActivated = $this->user_service->isActivated($return['user_id']);

			//check if facebook_app_id and google_app_id is empty
			if ($this->user_service->getFacebookId($return['user_id']) || $this->user_service->getGoogleId($return['user_id'])) {

				return $this->respondErrorMessage(2001);
			}

			if ($isActivated == 1) {


				// get code
				$code = $this->code_generator_service->getCodeExpiry();

				//update reset_code and expiry to db
				$this->user_service->setResetCode($return['user_id'], $code);


				if (strcasecmp($input['user_type'], config('futureed.student')) == 0) {

					$subject = str_replace('{user}', config('futureed.student'), $subject);

					$this->mail_service->sendStudentMailResetPassword($userDetails, $code['confirmation_code'], $input['callback_uri'], $subject);

				} elseif (strcasecmp($input['user_type'], config('futureed.client')) == 0) {

					$client_id = $this->client->getClientId($return['user_id']);

					$client = $this->client->getClientDetails($client_id);


					if ($client['account_status'] != config('futureed.client_account_status_accepted')) {

						return $this->respondErrorMessage(2013);
					}

					//update subject
					$subject = str_replace('{user}', $client->client_role, $subject);

					$subject = str_replace('{user}', config('futureed.client'), $subject);

					$this->mail_service->sendClientMailResetPassword($userDetails, $code['confirmation_code'], $input['callback_uri'], $subject);

				} else {

					$admin_id = $this->admin->getAdminId($return['user_id']);

					$admin = $this->admin->getAdminDetail($admin_id);

					//update subject
					$subject = str_replace('{user}', $admin->admin_role, $subject);

					$subject = str_replace('{user}', config('futureed.Admin'), $subject);

					$this->mail_service->sendAdminMailResetPassword($userDetails, $code['confirmation_code'], $input['callback_uri'], $subject);

				}

				return $this->respondWithData($userDetails->toArray());

			} else {

				return $this->respondErrorMessage(2018);

			}

		} else {

			return $this->respondErrorMessage(2018);
		}
    }

	/**
	 * confirmation of reset code.
	 * @return mixed
	 */
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
          
           $return=$this->user_service->getIdByEmail($input['email'],$input['user_type']);

          
           if($return['status']==202){
              
               return $this->respondErrorMessage(2001);
                        
           }else{

              $userdata = $this->user_service->getUserDetail($return['data'],$input['user_type']);
              
              if($userdata['reset_code']==$input['reset_code']){
                 
                  $expired=$this->user_service->checkCodeExpiry($userdata['reset_code_expiry']);
                 
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
