<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Services\UserServices;
use FutureEd\Services\MailServices;
use FutureEd\Services\CodeGeneratorServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserController extends ApiController{

    public function __construct(UserServices $user,MailServices $mail,CodeGeneratorServices $code){

        $this->user = $user;
        $this->mail = $mail;
        $this->code = $code;

    }


    //check user if exist
    public function checkUser(){
        $input = Input::only('username','user_type');

        //get email return user_id
        //else error message not exist.
        $username = $input['username'];
        $user_type = $input['user_type'];

        $return =  $this->user->checkUsername($username,$user_type);

        if(isset($return['error_code'])){

            return $this->setStatusCode(204)->respondWithError($return);

        }

        return $this->respondWithData(['id'=>$return['user_id']]);

    }

}
