<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Student\ClientRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ClientController extends ApiController {
	public function checkClientEmail(){
	        
	    }


	public function show($id){

		$client = config('futureed.client');

		$this->addMessageBag($this->validateVarNumber($id));

		$msg_bag = $this->getMessageBag();

        if(!empty($msg_bag)){

            return $this->respondWithError($this->getMessageBag());

        }else{

        	$return = $this->client->verifyClientId($id);

        	if($return){

        		$userDetails = $this->user->getUserDetail($return['user_id'],$client)->toArray();
        		$clienDetails = $this->client->getclientDetails($id)->toArray();
        		$formResponse = $this->client->formResponse($userDetails,$clienDetails);

        		return $this->respondWithData($formResponse);

        	} else{

        		return $this->respondErrorMessage(2001);


        	}

        }

	}

	public function update($id){

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
										  'school_state','school_country','school_zip');
				
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

				}

				$msg_bag = $this->getMessageBag();

				if($msg_bag){

					return $this->respondWithError($msg_bag);

				}else{

					$checkUsername = $this->user->checkUsername($user['username'],'Client');

	
				if(array_key_exists('error_code',$checkUsername) || $checkUsername['user_id'] == $clientDetails['user_id'] ){


					if(strtolower($clientDetails['client_role']) == 'parent' || 
					   strtolower($clientDetails['client_role']) == 'teacher'){

						$this->user->updateUsername($return['user_id'],$user['username']);
						$this->client->updateClientDetails($return['id'],$client);

					}else{

						$school_code = $this->school->checkSchoolNameExist($school);

						if(isset($school_code) && $school['school_code'] != $school_code){
							
							return $this->respondErrorMessage(2105);

						}else{

						    $this->user->updateUsername($return['user_id'],$user['username']);
							$this->client->updateClientDetails($return['id'],$client);
							$this->school->updateSchoolDetails($school);

						}

					}

					$clientDetails = $this->client->getclientDetails($id)->toArray();
					$userDetails = $this->user->getUserDetail($return['user_id'],'Client')->toArray();

					$response = $this->client->formResponse($userDetails,$clientDetails);

					return $this->respondWithData($response);

				}else{

					return $this->respondErrorMessage(2104);

				}


				}

			}else{

				return $this->respondErrorMessage(2001);
			}



			
		}




	}
}
