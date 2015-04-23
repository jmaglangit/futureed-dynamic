<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ClientController extends ApiController {
	public function register(){
	        $client = Input::only('first_name', 'last_name', 'client_role', 'street_address', 'city', 'state', 'country', 'zip');

	        $usersClient = Input::only('email', 'username', 'password', 'confirm_password');

	        $this->addMessageBag($this->firstName($client,'first_name'));
        	$this->addMessageBag($this->lastName($client,'last_name'));
        	$this->addMessageBag($this->clientRole($client,'client_role'));
        	$this->addMessageBag($this->validateString($client,'street_address'));
        	$this->addMessageBag($this->validateString($client,'city'));
        	$this->addMessageBag($this->validateString($client,'state'));
        	$this->addMessageBag($this->validateString($client,'country'));
        	$this->addMessageBag($this->zipCode($client,'zip'));

        	$this->addMessageBag($this->clientEmail($usersClient,'emial'));
        	$this->addMessageBag($this->clientUsername($usersClient,'username'));



        	$msg_bag = $this->getMessageBag();

        	if(!empty($msg_bag)){
        		return $this->setStatusCode(200)->respondWithError($msg_bag);
        	}
	    }
}
