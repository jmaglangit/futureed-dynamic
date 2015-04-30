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
}
