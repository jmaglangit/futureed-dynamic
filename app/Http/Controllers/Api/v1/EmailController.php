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

        if(is_null($return['user_id'])){
            return [
                'status' => 204,
                'errors' => [
                    'error_code' => 204,
                    'message' => 'Email does not exist'
                ]
            ];
        }

        return [
            'status' => 200,
            'data' => $return
        ];
    }

}
