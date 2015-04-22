<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ApiValidatorTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class EmailController extends ApiController {

    use ApiValidatorTrait;

	public function checkEmail(){
        $input = Input::only('email','user_type');

        //get email return user_id
        //else error message not exist.
        $email = $input['email'];
        $user_type = $input['user_type'];

        $this->addMessageBag($this->email($input,'email'));
        $this->addMessageBag($this->userType($input,'user_type'));

        $msg_bag = $this->getMessageBag();

        if(!empty($msg_bag)){

            return $this->respondWithError($this->getMessageBag());
        }

        $return =  $this->user->checkEmail($email,$user_type);

        if($input['user_type'] == 'Student'){

            $return['user_id'] = $this->student->getStudentId($return['user_id']);

        }

        if(isset($return['error_code'])){

            return $this->setStatusCode(201)->respondWithError($return);

        }

        return $this->respondWithData(['id'=>$return['user_id']]);
    }

}
