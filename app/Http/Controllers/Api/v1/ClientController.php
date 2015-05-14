<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Student\ClientRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ClientController extends ApiController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
	
		$criteria = array();
		$limit = 0;
		$offset = 0;
			
		if(Input::get('name')) {
			$criteria['name'] = Input::get('name');
		}
		
		if(Input::get('school_code')) {
			$criteria['school_code'] = Input::get('school_code');
		}
		
		if(Input::get('client_role')) {
			$criteria['client_role'] = Input::get('client_role');
		}
		
		if(Input::get('email')) {
			$criteria['email'] = Input::get('email');
		}
		
		if(Input::get('status')) {
			$criteria['status'] = Input::get('status');
		}
		
		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}
		
		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}
			
		$clients = $this->client->getClients($criteria, $limit, $offset);

		return $this->respondWithData($clients);
	}

	public function show($id) {

		$client = config('futureed.client');

		$this->addMessageBag($this->validateVarNumber($id));

		$msg_bag = $this->getMessageBag();

        if(!empty($msg_bag)){

            return $this->respondWithError($this->getMessageBag());

        } else {

        	$return = $this->client->verifyClientId($id);

        	if($return) {

        		$userDetails = $this->user->getUserDetail($return['user_id'],$client)->toArray();
        		$clienDetails = $this->client->getclientDetails($id)->toArray();
        		$formResponse = $this->client->formResponse($userDetails,$clienDetails);

        		return $this->respondWithData($formResponse);

        	} else {

        		return $this->respondErrorMessage(2001);

        	}

        }

	}

	public function update($id){

        //Check token authentication if valid.
        $access_token = \Request::header('access_token');

        $this->validateToken($access_token);

        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }

		$this->addMessageBag($this->validateVarNumber($id));

		$msg_bag = $this->getMessageBag();

		if($msg_bag){

			return $this->respondWithError($msg_bag);

		}else{

			$return = $this->client->verifyClientId($id);

			if($return){

				$clientDetails = $this->client->getclientDetails($id)->toArray();
				$userDetails = $this->user->getUserDetail($return['user_id'],'Client')->toArray();

				$user = input::only('username');

				$client = input::only('first_name','last_name','street_address',
									  'city','country','zip','state');

				$school = input::only('school_name','school_code','school_street_address','school_city',
										  'school_state','school_country','school_zip','school_contact_name','school_contact_number');
				
				$this->addMessageBag($this->username($user,'username'));
				$this->addMessageBag($this->firstName($client,'first_name'));
				$this->addMessageBag($this->lastName($client,'last_name'));
				

				if(strtolower($clientDetails['client_role']) == 'parent'){

					$this->addMessageBag($this->validateString($client,'street_address'));
					$this->addMessageBag($this->validateString($client,'city'));
					$this->addMessageBag($this->validateString($client,'country'));
					$this->addMessageBag($this->validateString($client,'state'));
					$this->addMessageBag($this->zipCode($client,'zip'));

				}else if(strtolower($clientDetails['client_role']) == 'teacher'){

					$this->addMessageBag($this->validateStringOptional($client,'street_address'));
					$this->addMessageBag($this->validateStringOptional($client,'city'));
					$this->addMessageBag($this->validateStringOptional($client,'country'));
					$this->addMessageBag($this->validateStringOptional($client,'state'));
					$this->addMessageBag($this->zipCodeOptional($client,'zip'));


				}else{

					$this->addMessageBag($this->validateStringOptional($client,'street_address'));
					$this->addMessageBag($this->validateStringOptional($client,'city'));
					$this->addMessageBag($this->validateStringOptional($client,'country'));
					$this->addMessageBag($this->validateStringOptional($client,'state'));
					$this->addMessageBag($this->zipCodeOptional($client,'zip'));
					
					$this->addMessageBag($this->validateNumber($school,'school_code'));
					$this->addMessageBag($this->validateString($school,'school_name'));
					$this->addMessageBag($this->validateString($school,'school_state'));
					$this->addMessageBag($this->validateString($school,'school_country'));
					$this->addMessageBag($this->validateStringOptional($school,'school_street_address'));
					$this->addMessageBag($this->validateStringOptional($school,'school_city'));
					$this->addMessageBag($this->zipCodeOptional($school,'school_zip'));
					$this->addMessageBag($this->validateString($school,'school_contact_name'));
					$this->addMessageBag($this->checkContactNumber($school,'school_contact_number'));

				}

				$msg_bag = $this->getMessageBag();

				if($msg_bag){

					return $this->respondWithError($msg_bag);

				}else{

					$checkUsername = $this->user->checkUsername($user['username'],'Client');

	
				if(!($checkUsername)  || $checkUsername['user_id'] == $clientDetails['user_id'] ){


					if(strtolower($clientDetails['client_role']) == 'parent' || 
					   strtolower($clientDetails['client_role']) == 'teacher'){

						$this->user->updateUsername($return['user_id'],$user['username']);
						$this->client->updateClientDetails($return['id'],$client);

					}else{

						$school_code = $this->school->checkSchoolNameExist($school);
						$school_name = $this->school->getSchoolName($school['school_code']);

						if(empty($school_name)){

							return $this->setHeader($this->getToken())->respondErrorMessage(2105);

						}else if(isset($school_code) && $school['school_code'] != $school_code){
							
							return $this->setHeader($this->getToken())->respondErrorMessage(2202);

						}else{

						    $this->user->updateUsername($return['user_id'],$user['username']);
							$this->client->updateClientDetails($return['id'],$client);
							$this->school->updateSchoolDetails($school);

						}

					}

					$clientDetails = $this->client->getclientDetails($id)->toArray();
					$userDetails = $this->user->getUserDetail($return['user_id'],'Client')->toArray();

					$response = $this->client->formResponse($userDetails,$clientDetails);

					return $this->setHeader($this->getToken())->respondWithData($response);

				}else{

					return $this->setHeader($this->getToken())->respondErrorMessage(2104);

				}


				}

			}else{

				return $this->setHeader($this->getToken())->respondErrorMessage(2001);
			}



			
		}




	}
}
