<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Student\ClientRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminClientController extends ApiController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function setClientStatus($id){

		$input = Input::only('status');

		$this->addMessageBag($this->validateVarNumber($id));
		$this->addMessageBag($this->validateStatus($input,'status'));

		$msg_bag = $this->getMessageBag();

		if($msg_bag){

			return $this->respondWithError($msg_bag);

		}else{

			$verify_client = $this->client->verifyClientId($id);

			if(!$verify_client){

				return $this->respondErrorMessage(2001);
			}

			//update status for user
			$this->user->updateStatus($verify_client['user_id'],$input['status']);

			return $this->respondWithData([
											'id' =>$id
										 ]);

		}
		
	}

	

}
