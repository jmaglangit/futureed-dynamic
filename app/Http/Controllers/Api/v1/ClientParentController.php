<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ClientParentController extends ApiController {

	public function getStudentList($id){

        $this->addMessageBag($this->validateVarNumber($id));

        if($this->getMessageBag()){

            return $this->respondWithError($this->getMessageBag());
        }

        $students = $this->student->getStudentByParent($id);

        return $this->respondWithData($students);
    }

}
