<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ClientParentController extends ApiController {

	public function getStudentList($id){

        //Check token authentication if valid.
        $access_token = \Request::header('authorization');

        $this->validateToken($access_token);

        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }

        $parent_role = config('futureed.parent');

        $this->addMessageBag($this->validateVarNumber($id));

        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }

        //TODO: check client if exist
        $stud_list = $this->client->checkClient($id,$parent_role);

        if(is_null($stud_list)){

            return $this->setHeader($this->getToken())->respondErrorMessage(2010);
        }

        $students = $this->student->getStudentByParent($id);

        return $this->setHeader($this->getToken())->respondWithData($students);
    }

}
