<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ClientValidatorTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Services\ClientServices;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use League\Flysystem\Exception;

class ClientRegisterController extends ClientController {
	
	use ClientValidatorTrait;

	public function register(){

	        $client = Input::only('first_name', 'last_name', 'client_role', 'street_address', 'city', 'state', 'country', 'zip');

	        $user = Input::only('username', 'email', 'first_name', 'last_name', 'password', 'confirm_password');

	        $school = Input::only('school_name', 'school_address', 'school_state', 'school_country', 'school_zip');

	        $this->addMessageBag($this->firstName($client,'first_name'));
        	$this->addMessageBag($this->lastName($client,'last_name'));
        	$this->addMessageBag($this->clientRole($client,'client_role'));
        	$this->addMessageBag($this->validateString($client,'street_address'));
        	$this->addMessageBag($this->validateString($client,'city'));
        	$this->addMessageBag($this->validateString($client,'state'));
        	$this->addMessageBag($this->validateString($client,'country'));
        	$this->addMessageBag($this->zipCode($client,'zip'));
        	$this->addMessageBag($this->email($user,'email'));
        	$this->addMessageBag($this->username($user,'username'));

        	if($client['client_role'] == 'Principal'){
        		$this->addMessageBag($this->schoolName($school,'school_name'));
        		$this->addMessageBag($this->schoolAddress($school,'school_address'));
        		$this->addMessageBag($this->schoolState($school,'school_state'));
        		$this->addMessageBag($this->schoolCountry($school,'school_country'));
        		$this->addMessageBag($this->zipCode($school,'school_zip'));
        	}

        	$msg_bag = $this->getMessageBag();

        	$error_msg = config('futureed-error.error_messages');

        	$email_check = $this->client->checkClientEmail($user);

        	if($email_check == false){

        		$email_err[] = [
        			"error_code" => 2200,
        			"field" => 'email',
        			"message" => $error_msg[2200]
        			];

        		$msg_bag = array_merge($msg_bag, $email_err);

        	}

        	$username_check = $this->client->checkClientUsername($user);

        	if($username_check == false){

        		$user_err[] = [
        			"error_code" => 2201,
        			"field" => 'username',
        			"message" => $error_msg[2201]
        			];

        		$msg_bag = array_merge($msg_bag, $user_err);

        	}

        	$check_school_name = $this->client->schoolNameCheck($school);

        	if($check_school_name == false){

        		$user_err[] = [
        			"error_code" => 2202,
        			"field" => 'school_name',
        			"message" => $error_msg[2202]
        			];

        		$msg_bag = array_merge($msg_bag, $user_err);

        	}


        	if(!empty($msg_bag)){
        		return $this->setStatusCode(200)->respondWithError($msg_bag);
        	}       	

        	unset($user['confirm_password']);

        	$user = array_merge($user,[
            	'user_type' => config('futureed.client')
        	]);

        	// add user, return status
        	$user_response = $this->user->addUser($user);

        	if(isset($user_response['status'])){
        		$client = array_merge($client, [
        			'user_id' => $user_response['id']
        			]);
        		$client_response = $this->client->addClient($client);
        	}

	    }
	
}
