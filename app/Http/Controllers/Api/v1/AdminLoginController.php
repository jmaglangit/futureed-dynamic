<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ClientValidatorTrait;
use FutureEd\Http\Controllers\Api\v1\ClientController;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Services\UserServices;
use FutureEd\Services\AdminServices;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminLoginController extends ApiController {

    public function __construct(UserServices $user,AdminServices $admin){

        $this->admin = $admin;
        $this->user  = $user;   
    }

	public function login(){

        $error = config('futureed-error.error_messages');
        $input = Input::only('username','password');


        $this->addMessageBag($this->username($input,'username'));
        $this->addMessageBag($this->checkPassword($input,'password'));

        $msg_bag = $this->getMessageBag();

        if($msg_bag){
            return $this->respondWithError($msg_bag);
        }else{

            //check username
            $response =$this->user->checkLoginName($input['username'],config('futureed.admin'));

            if($response['status'] <> 200){
                return $this->respondErrorMessage(2001);
            }

            //check password

            $input['password'] = sha1($input['password']);
            $return  = $this->user->checkPassword($response['data'],$input['password']);

            if(!$return){

                $this->user->addLoginAttempt($response['data']);
                return $this->respondErrorMessage(2233);
            }

           $admin_id= $this->admin->getAdminId($return['id']);
           $admin_detail = $this->admin->getAdmin($admin_id);

           return $this->respondWithData([
                'id' => $admin_detail['id'],
                'first_name' => $admin_detail['first_name'],
                'last_name' => $admin_detail['last_name']
           ]);

        }


       
    }

}