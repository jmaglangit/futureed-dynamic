<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\ClientValidatorTrait;
use FutureEd\Http\Controllers\Api\v1\ClientController;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Services\TokenServices;
use FutureEd\Services\UserServices;
use FutureEd\Services\AdminServices;
use FutureEd\Services\PasswordServices;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminLoginController extends ApiController {

    public function __construct(UserServices $user,AdminServices $admin, PasswordServices $password, TokenServices $tokenServices){

        $this->admin = $admin;
        $this->user  = $user;   
        $this->password = $password;
        $this->token = $tokenServices;
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
                $user = $this->user->getUserDetail($response['data'],config('futureed.admin'));

                if($user['login_attempt'] >=3){

                    $this->user->lockAccount($response['data']);

                }


                return $this->respondErrorMessage(2233);
            }

           $admin_id= $this->admin->getAdminId($return['id']);
           $admin_detail = $this->admin->getAdmin($admin_id);

            $token = $this->token->getToken([
                'id' => $admin_detail['id'],
                'type' => config('futureed.admin'),
                'role' => $admin_detail['admin_role']
            ]);


           return $this->setHeader($token)->respondWithData([
                'id' => $admin_detail['id'],
                'first_name' => $admin_detail['first_name'],
                'last_name' => $admin_detail['last_name']
           ]);

        }


       
    }

}