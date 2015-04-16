<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

class GradeController extends ApiController {

    //get list of grade levels
	public function grade(){

        $response = $this->grade->getGrades();

        return $this->respondWithData($response);


    }

}
