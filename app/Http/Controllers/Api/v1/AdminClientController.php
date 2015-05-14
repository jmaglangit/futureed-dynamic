<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Student\ClientRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminClientController extends ClientController {

	public function addClient(){

        $user_type = config('futureed.client');

        $client = Input::only('first_name', 'last_name', 'client_role', 
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
		    $this->addMessageBag($this->zipCodeOptional($client,'zip'));

        }else{

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

                //add user to db
                $user_response = $this->user->addUser($user,$client);

                $client['user_id'] = $user_response['id'];
                $client['school_code'] = null;

                if(strcasecmp($client['client_role'],config('futureed.teacher')) == 0){

                    $client['school_code'] = $check_school;

                }else if(strcasecmp($client['client_role'],config('futureed.principal')) == 0){

                    //add school to do do
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

}