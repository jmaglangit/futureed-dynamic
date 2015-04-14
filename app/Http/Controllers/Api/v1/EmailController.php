<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class EmailController extends ApiController {

	public function checkEmail(){
        $input = Input::only('email','user_type');

        //get email return user_id
        //else error message not exist.
        $email = $input['email'];
        $user_type = $input['user_type'];

        $return =  $this->user->checkEmail($email,$user_type);

        if(isset($return['error_code'])){

            return $this->setStatusCode(201)->respondWithError($return);

        }

        return $this->respondWithData(['id'=>$return['user_id']]);
    }

}
