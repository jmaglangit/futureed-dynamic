<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Student\ClientRepositoryInterface;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ClientController extends ApiController {

	//TODO: create __construct function.

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
		
		if(Input::get('school')) {
			$criteria['school'] = Input::get('school');
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

                //TODO: make use of relationships.
        		$userDetails = $this->user->getUserDetail($return['user_id'],$client)->toArray();
        		$clienDetails = $this->client->getClientDetails($id)->toArray();
        		$formResponse = $this->client->formResponse($userDetails,$clienDetails);

        		return $this->respondWithData($formResponse);

        	} else {

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

				$clientDetails = $this->client->getClientDetails($id)->toArray();
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
					
					$this->addMessageBag($this->schoolCode($school,'school_code'));
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
					$user['name'] = $client['first_name'].$client['last_name'];

	
				if(!($checkUsername)  || $checkUsername['user_id'] == $clientDetails['user_id'] ){


					if(strtolower($clientDetails['client_role']) == 'parent' || 
					   strtolower($clientDetails['client_role']) == 'teacher'){

						$this->user->updateUsername($return['user_id'],$user);
						$this->client->updateClientDetails($return['id'],$client);

					}else{

						$school_code = $this->school->checkSchoolNameExist($school);
						$school_name = $this->school->getSchoolName($school['school_code']);

						if(empty($school_name)){

							return $this->respondErrorMessage(2105);

						}else if(isset($school_code) && $school['school_code'] != $school_code){
							
							return $this->respondErrorMessage(2202);

						}else{

						    $this->user->updateUsername($return['user_id'],$user);
							$this->client->updateClientDetails($return['id'],$client);
							$this->school->updateSchoolDetails($school);

						}

					}

					$clientDetails = $this->client->getClientDetails($id)->toArray();
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



	public function store(){


        $user_type = config('futureed.client');

        $client = Input::only('first_name', 'last_name', 'client_role', 'school_code',
                              'street_address', 'city', 'state', 'country', 'zip');

        $user = Input::only('username', 'email','status');

        $school = Input::only('school_name', 'school_address', 'school_city', 
                              'school_state', 'school_country', 'school_zip',
                              'contact_name','contact_number');

        $input = Input::only('callback_uri');

        $error_msg = config('futureed-error.error_messages');

        $this->addMessageBag($this->clientRole($client ,'client_role'));
        $this->addMessageBag($this->firstName($client,'first_name'));
        $this->addMessageBag($this->lastName($client,'last_name'));      	
        $this->addMessageBag($this->email($user,'email'));
        $this->addMessageBag($this->username($user,'username'));
        $this->addMessageBag($this->validateString($input,'callback_uri'));
        $this->addMessageBag($this->validateStatus($user,'status'));


        if(strcasecmp($client['client_role'],config('futureed.parent')) == 0){

        	$this->addMessageBag($this->validateString($client,'street_address'));
            $this->addMessageBag($this->validateString($client,'city'));
            $this->addMessageBag($this->validateString($client,'state'));
            $this->addMessageBag($this->validateString($client,'country'));
            $this->addMessageBag($this->zipCode($client,'zip'));
            

        }else if(strcasecmp($client['client_role'],config('futureed.teacher')) == 0){

        	$this->addMessageBag($this->validateString($school,'school_name'));
        	$this->addMessageBag($this->validateStringOptional($client,'street_address'));
			$this->addMessageBag($this->validateStringOptional($client,'city'));
			$this->addMessageBag($this->validateStringOptional($client,'country'));
		    $this->addMessageBag($this->validateStringOptional($client,'state'));
            $this->addMessageBag($this->validateNumber($client,'school_code'));
		    $this->addMessageBag($this->zipCodeOptional($client,'zip'));

        }else if(strcasecmp($client['client_role'],config('futureed.principal')) == 0){

        	$this->addMessageBag($this->validateStringOptional($client,'street_address'));
			$this->addMessageBag($this->validateStringOptional($client,'city'));
			$this->addMessageBag($this->validateStringOptional($client,'country'));
			$this->addMessageBag($this->validateStringOptional($client,'state'));
			$this->addMessageBag($this->zipCodeOptional($client,'zip'));
					
			$this->addMessageBag($this->validateString($school,'school_name'));
			$this->addMessageBag($this->validateString($school,'school_state'));
			$this->addMessageBag($this->validateString($school,'school_country'));
			$this->addMessageBag($this->validateString($school,'school_address'));
			$this->addMessageBag($this->validateString($school,'school_city'));
			$this->addMessageBag($this->zipCode($school,'school_zip'));
            $this->addMessageBag($this->validateString($school,'contact_name'));
            $this->addMessageBag($this->checkContactNumber($school,'contact_number'));

        }


        $msg_bag = $this->getMessageBag();

		if($msg_bag){

			return $this->respondWithError($msg_bag);

		}else{

            $check_username = $this->user->checkUsername($user['username'],$user_type);
            $check_email = $this->user->checkEmail($user['email'],$user_type);
            $school['school_street_address'] = $school['school_address'];

            //for teacher get school_code via school name if exist 
            $check_school = $this->school->getSchoolCode($school['school_name']);

            //for principal check if school is unique
            $school_exist = $this->school->checkSchoolNameExist($school);

            
            if($check_username){

                return $this->respondErrorMessage(2104);

            }else if( $check_email ){

                return $this->respondErrorMessage(2200);

            }else if(strcasecmp($client['client_role'],config('futureed.teacher')) == 0  && !($check_school)){

                return $this->respondErrorMessage(2105);

            }else if(strcasecmp($client['client_role'],config('futureed.principal')) == 0 && $school_exist){

                return $this->respondErrorMessage(2202);

            }else{

                $user['first_name'] = $client['first_name'];
                $user['last_name'] = $client['last_name'];
                $user['user_type']  = $user_type;
                $client['account_status'] = config('futureed.client_account_status_accepted');

                //add user to db
                $user_response = $this->user->addUser($user,$client);

                $client['user_id'] = $user_response['id'];

                if(strcasecmp($client['client_role'],config('futureed.principal')) == 0){

                    //add school to db
                    $school_response = $this->school->addSchool($school);

                    $client['school_code'] = $school_response;

                }

                    $client_response = $this->client->addClient($client);
                    $data = $this->user->getUser($user_response['id'],'Client');
                    $code = $this->user->getConfirmationCode($user_response['id']);
                    $data['client_role'] = $client['client_role'];

                     // send email to user
                     $this->mail->sendClientRegister($data,$code['confirmation_code'],$input['callback_uri']);

                     return $this->respondWithData(['id' => $client_response['id'] 
                                                  ]);


            }

		}

	}

    public function destroy($id){

        $user_type = config('futureed.client');


        $this->addMessageBag($this->validateVarNumber($id));

        $msg_bag = $this->getMessageBag();

        if($msg_bag){

            return $this->respondWithError($msg_bag);

        }

        $return = $this->client->getClientDetails($id);

        if(!$return){

            return $this->respondErrorMessage(2001);
        }

        //check principal if assign to school
        if($return['school_code'] && $return['client_role']=== config('futureed.principal')){

            return $this->respondErrorMessage(2121);

        }
        //check relation of teacher to classroom
        $teacher_classroom = $this->client->getClassroom($id);

        if( $teacher_classroom['classroom']->toArray() && $return['client_role']=== config('futureed.teacher')){

            return $this->respondErrorMessage(2122);
        }

        //check parent to student
        $parent_student = $this->client->getStudent($id);

        if($parent_student['student']->toArray() && $return['client_role']=== config('futureed.parent')){

            return $this->respondErrorMessage(2123);

        }

		//check client has discount
		$client_discount = $this->client_discount->checkClient($id);


		if($client_discount){

			return $this->respondErrorMessage(2036);
		}



        return $this->respondWithData([$this->client->deleteClient($id)]);



    }
}
