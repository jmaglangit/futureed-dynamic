<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ClientValidatorTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Services\ClientServices;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use League\Flysystem\Exception;

use Carbon\Carbon;

class ClientRegisterController extends ClientController {
	
	use ClientValidatorTrait;

	public function register(){

        // cannot be use for teacher registration

	        $client = Input::only('first_name', 'last_name', 'client_role', 'street_address', 'city', 'state', 'country', 'zip');

	        $user = Input::only('username', 'email', 'first_name', 'last_name', 'password');

	        $school = Input::only('school_name', 'school_address', 'school_city', 'school_state', 'school_country', 'school_zip','contact_name','contact_number');

            $input = Input:: only('callback_uri');

            $error_msg = config('futureed-error.error_messages');


           


            $this->addMessageBag($this->checkPassword($user,'password'));
            $this->addMessageBag($this->validateString($input,'callback_uri'));

	        $this->addMessageBag($this->firstName($client,'first_name'));
        	$this->addMessageBag($this->lastName($client,'last_name'));
        	$this->addMessageBag($this->clientRole($client,'client_role'));        	
        	$this->addMessageBag($this->email($user,'email'));
        	$this->addMessageBag($this->username($user,'username'));


            if(strtolower($client['client_role']) == strtolower(config('futureed.teacher'))){

                $this->addMessageBag($this->setErrorCode(2234)
                                ->setField('client_role')
                                ->setMessage($error_msg[2234])
                                ->errorMessage());
            }    

            if(strtolower($client['client_role']) == strtolower(config('futureed.parent'))){
                $this->addMessageBag($this->validateString($client,'street_address'));
                $this->addMessageBag($this->validateAlpha($client,'city'));
                $this->addMessageBag($this->validateAlpha($client,'state'));
                $this->addMessageBag($this->validateString($client,'country'));
                $this->addMessageBag($this->zipCodeOptional($client,'zip'));
            }else{
                $this->addMessageBag($this->validateString($school,'school_name'));
                $this->addMessageBag($this->schoolAddress($school,'school_address'));
                $this->addMessageBag($this->validateAlpha($school,'school_state'));
                $this->addMessageBag($this->validateString($school,'school_country'));
                $this->addMessageBag($this->zipCodeOptional($school,'school_zip'));
                $this->addMessageBag($this->validateAlphaSpace($school,'contact_name'));
                $this->addMessageBag($this->checkContactNumber($school,'contact_number'));


                $this->addMessageBag($this->validateStringOptional($client,'street_address'));
                $this->addMessageBag($this->validateAlphaOptional($client,'city'));
                $this->addMessageBag($this->validateAlphaOptional($client,'state'));
                $this->addMessageBag($this->validateStringOptional($client,'country'));
                $this->addMessageBag($this->zipCodeOptional($client,'zip'));
            }
        	
        	$email_check = $this->client->checkClientEmail($user);

        	if(!$email_check){

        		$this->addMessageBag($this->setErrorCode(2200)
                	->setField('email')
                	->setMessage($error_msg[2200])
                	->errorMessage());
        		
        	}

        	$username_check = $this->client->checkClientUsername($user);

        	if(!$username_check){

        		$this->addMessageBag($this->setErrorCode(2201)
                	->setField('username')
                	->setMessage($error_msg[2201])
                	->errorMessage());

        	}


          if(strtolower($client['client_role']) == strtolower(config('futureed.principal'))){
            	$check_school_name = $this->client->schoolNameCheck($school);

            	if(!$check_school_name){

            		$this->addMessageBag($this->setErrorCode(2202)
                    	->setField('school_name')
                    	->setMessage($error_msg[2202])
                    	->errorMessage());

            	}
          }

        	$msg_bag = $this->getMessageBag();

        	if(!empty($msg_bag)){
        		return $this->respondWithError($msg_bag);
        	}       	

        	$user['user_type'] = config('futureed.client');

        	// add user, return status
        	$user_response = $this->user->addUser($user);
        	
        	if($client['client_role'] == config('futureed.principal')){

        		// add school, return status
        	$school_response = $this->school->addSchool($school);
        	}
        	
        	if(isset($user_response['status']) || isset($school_response['status'])){

        		$client = array_merge($client, [
        			'user_id' 		=> $user_response['id'],
        			'school_code'		=> (isset($school_response)) ? $school_response : null,
        		      ]);

        		$client_response = $this->client->addClient($client);

        	}

        	if(isset($client_response['status'])){

        		$data = $this->user->getUser($user_response['id'],'Client');

        		$code = $this->user->getConfirmationCode($user_response['id']);

        		$data['client_role'] = $client['client_role'];
        		// send email to user
        		$this->mail->sendClientRegister($data,$code['confirmation_code'],$input['callback_uri']);

        		return $this->respondWithData([
        				'id'	=> $client_response['id'],
        			]);
        	}else {

            $return = array_merge($user_response,$client_response);

            return $this->respondWithError($return);

        }
	    }
	
}
