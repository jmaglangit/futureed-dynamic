<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ClientController extends Controller {

	public function getStudentList(){
        $input = Input::only('id');

        //get list of students of the parents.


        return $input;

    }

}
