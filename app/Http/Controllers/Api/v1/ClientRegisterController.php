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

	        $client = Input::only('first_name', 'last_name', 'client_role', 'street_address', 'city', 'state', 'country', 'zip');

	        $user = Input::only('username', 'email', 'first_name', 'last_name', 'password');

	        $school = Input::only('school_name', 'school_address', 'school_city', 'school_state', 'school_country', 'school_zip');

	        $this->addMessageBag($this->firstName($client,'first_name'));
        	$this->addMessageBag($this->lastName($client,'last_name'));
        	$this->addMessageBag($this->clientRole($client,'client_role'));   	
        	$this->addMessageBag($this->checkPassword($user,'password'));
            $this->addMessageBag($this->email($user,'email'));
            $this->addMessageBag($this->username($user,'username'));

            if(!empty($client['street_address'])){

                $this->addMessageBag($this->validateString($client,'street_address'));

            }elseif(!empty($client['city'])){

                $this->addMessageBag($this->validateString($client,'city'));

            }elseif(!empty($client['state'])){

                $this->addMessageBag($this->validateString($client,'state'));

            }elseif(!empty($client['country'])){

                $this->addMessageBag($this->validateString($client,'country'));

            }elseif(!empty($client['zip'])){

                $this->addMessageBag($this->zipCode($client,'zip'));
            }

        	if($client['client_role'] == config('futureed.principal')){
        		$this->addMessageBag($this->schoolName($school,'school_name'));
        		$this->addMessageBag($this->schoolAddress($school,'school_address'));
        		$this->addMessageBag($this->validateString($school,'school_state'));
        		$this->addMessageBag($this->validateString($school,'school_country'));
        		$this->addMessageBag($this->zipCode($school,'school_zip'));
        	}

        	$error_msg = config('futureed-error.error_messages');

        	$email_check = $this->client->checkClientEmail($user);

        	if($email_check == false){

        		$this->addMessageBag($this->setErrorCode(2200)
                	->setField('email')
                	->setMessage($error_msg[2200])
                	->errorMessage());
        		
        	}

        	$username_check = $this->client->checkClientUsername($user);

        	if($username_check == false){

        		$this->addMessageBag($this->setErrorCode(2201)
                	->setField('username')
                	->setMessage($error_msg[2201])
                	->errorMessage());

        	}

        	$check_school_name = $this->client->schoolNameCheck($school);

        	if($check_school_name == false){

        		$this->addMessageBag($this->setErrorCode(2202)
                	->setField('school_name')
                	->setMessage($error_msg[2202])
                	->errorMessage());

        	}

        	$msg_bag = $this->getMessageBag();

        	if(!empty($msg_bag)){
        		return $this->setStatusCode(200)->respondWithError($msg_bag);
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
        			'school_code'		=> (isset($school['code'])) ? $school['code'] : null,
        			]);

        		$client_response = $this->client->addClient($client);

        	}

        	if(isset($client_response['status'])){

        		$data = $this->user->getUser($user_response['id'],'Client')->toArray();

        		$code = $this->user->getConfirmationCode($user_response['id'])->toArray();

        		$data['client_role'] = $client['client_role'];

        		// send email to user
        		$this->mail->sendClientRegister($data,$code['confirmation_code']);

        		return $this->respondWithData([
        				'id'	=> $client_response['id'],
        			]);
        	}else {

            $return = array_merge($user_response,$client_response);

            return $this->respondWithError($return);

        }
	    }
	
}
