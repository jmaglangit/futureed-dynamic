<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Services\UserServices;
use FutureEd\Services\MailServices;
use FutureEd\Services\CodeGeneratorServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserController extends ApiController{


    //check user if exist
    public function checkUser(){
        $input = Input::only('username','user_type');

        //get email return user_id
        //else error message not exist.
        $username = $input['username'];
        $user_type = $input['user_type'];

        $return =  $this->user->checkUsername($username,$user_type);

        if($input['user_type'] == 'Student'){

            $return['user_id'] = $this->student->getStudentId($return['user_id']);

        }

        if(isset($return['error_code'])){

            return $this->setStatusCode(204)->respondWithError($return);

        }

        return $this->respondWithData(['id'=>$return['user_id']]);

    }

    //confirmation of email code
    public function confirmEmailCode(){
        $input = Input::only('email','email_code','user_type');

        if(!$input['email'] || !$input['email_code'] || !$input['user_type']){

            return $this->setStatusCode(422)
                ->respondWithError(['error_code'=>422,
                    'message'=>'Parameter validation failed'
                ]);
        }

        //confirm email code
        //check email
        $user_check = $this->user->checkEmail($input['email'],$input['user_type']);
        if(isset($user_check['error_code'])){

            return $this->respondWithError($user_check);
        }

        //check code
        //get user detail
        $user_detail = $this->user->getUserDetail($user_check['user_id'],$input['user_type']);

        if($input['email_code'] <> $user_detail['confirmation_code']){

            return $this->respondWithError([
                'error_code' => 204,
                'message' => 'Code does not match'
            ]);
        }

        $code_expire = $this->user->checkCodeExpiry($user_detail['confirmation_code_expiry']);
        if($code_expire){

            return $this->respondWithError([
                'error_code' => 204,
                'message' => 'Code expired'
            ]);
        }

        $return = $this->student->getStudentId($user_detail['id']);
        return $this->respondWithData([
            'id' => $return
        ]);

    }

}
