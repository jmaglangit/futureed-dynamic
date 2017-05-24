<?php namespace FutureEd\Http\Controllers\Api\v1;


use FutureEd\Http\Requests;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Services\PasswordServices;
use FutureEd\Services\UserServices;
use Illuminate\Support\Facades\Input;

class ClientLoginController extends ClientController {

    protected $user_service;

    protected $client;

    protected $password;

    public function __construct(
        UserServices $userServices,
        ClientRepositoryInterface $clientRepositoryInterface,
        PasswordServices $passwordServices
    ){
        $this->user_service = $userServices;
        $this->client = $clientRepositoryInterface;
        $this->password = $passwordServices;
    }

	public function login(){
        $input = Input::only('username','password','role');

        if(!$this->email($input,'username')){
            
            $this->addMessageBag($this->email($input,'username'));
             
        }else{

             $this->addMessageBag($this->username($input,'username'));
        }
        

        $this->addMessageBag($this->checkPassword($input,'password'));
        $this->addMessageBag($this->clientRole($input,'role'));

        $msg_bag = $this->getMessageBag();

            if(!empty($msg_bag)){
                return $this->respondWithError($msg_bag);
            } 

        //check username and password
        $response =$this->user_service->checkLoginName($input['username'], 'Client');

        if($response['data'] == 2034 ){
            return $this->respondWithError([[
                    'error_code' => 2034,
                    'message' => $response['message']]
            ]);
        }

        if($response['status'] <> 200){

            return $this->respondErrorMessage($response['data']);
        }

        //check if facebook_app_id and google_app_id is empty
        if($this->user_service->getFacebookId($response['data']) || $this->user_service->getGoogleId($response['data'])){

            return $this->respondErrorMessage(2001);
        }

        $client_id = $this->client->getClientId($response['data']);

        //check role of user if exist
        $client_role = $this->client->checkClient($client_id,$input['role']);

        if(is_null($client_role)){

            return $this->respondErrorMessage(2001);
        }

        //get client basic detail
        $client_detail = $this->client->getClient($client_role,$input['role']);

        if($client_detail['account_status'] != config('futureed.client_account_status_accepted')){

            return $this->respondErrorMessage(2118);
        }


         //match username and password
        $input['password'] = sha1($input['password']);
        $return  = $this->user_service->checkPassword($response['data'],$input['password']);

        if(!$return){

            $this->user_service->addLoginAttempt($response['data']);

            $user = $this->user_service->getUserDetail($response['data'],'Client');

            if($user['login_attempt'] >=3){

                $this->user_service->lockAccount($response['data']);

                return $this->respondErrorMessage(2014);

            } else {
                //check remaining attempts
                $err_message = trans('errors.2074', ['remaining_attempts' => (config('futureed.limit_attempt') - $user['login_attempt'])]);

                return $this->respondWithError([[
                    'error_code' => 2074,
                    'message' => $err_message
                ]]);

            }

            return $this->respondErrorMessage(2033);
        }

		//get user details
		$user_details = $this->user_service->getUserDetail($response['data'],config('futureed.client'));

		//check if user is Disabled
		if($user_details['status'] === config('futureed.user_disabled')){

			return $this->respondErrorMessage(2013);
		}

        if(strcasecmp($client_detail['client_role'],config('futureed.teacher')) == 0){

            $country = $client_detail->school['country_id'];

            //curriculum country is principals'
            $curriculum_country = $client_detail->school->principal->user->curriculum_country;

        } elseif(strcasecmp($client_detail['client_role'],config('futureed.principal')) == 0){

            $country = $client_detail->school['country_id'];

            //curriculum country is principal'
            $curriculum_country = $client_detail->user->curriculum_country;

        } else {

            $country = $client_detail['country_id'];

            //curriculum country is parents'
            $curriculum_country = $client_detail->user->curriculum_country;
        }

        $this->user_service->resetLoginAttempt($return['id']);

        return $this->respondWithData([
			'id' => $client_detail['id'],
            'user' => $client_detail->user,
			'first_name' => $client_detail['first_name'],
			'last_name' => $client_detail['last_name'],
			'country_id' => $country,
            'curriculum_country' => $curriculum_country
        ]);
    }

}
