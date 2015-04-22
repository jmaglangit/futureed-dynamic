<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ClientParentController extends ApiController {

	public function getStudentList($id){

        $students = $this->student->getStudentByParent($id);

        return $this->respondWithData([
            $students
        ]);
    }

}
