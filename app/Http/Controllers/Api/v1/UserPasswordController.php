<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserPasswordController extends UserController {

	//

    public function passwordForgot(){
        $input = Input::only('username','user_type');

        if(!$input['username']){

            return $this->respondNotFound();

        } else {

            return $input;
//            $username = $this->user->checkLoginName($input['username'],$input['user_type']);


            /**
             * TODO: check user if exist.
             * TODO: if exist generate password reset code.
             * TODO: send email with code and reset link.
             */
        }

    }

    public function passwordReset(){
        $input = Input::only('reset_code');


    }

}
