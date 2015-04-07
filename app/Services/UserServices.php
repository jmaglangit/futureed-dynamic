<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 1:50 PM
 */
namespace FutureEd\Services;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Models\Repository\Validator\ValidatorRepositoryInterface;
class UserServices {
    /**
     *
     */
    public function __construct(UserRepositoryInterface $users,ValidatorRepositoryInterface $validator){
        $this->users = $users;
        $this->validator = $validator;
    }
    public function getUsers(){
        return $this->users->getUsers();
    }
    public function getUser($id){
        return $this->users->getUser($id);
    }
    public function getUserByType($id,$type){
        //get user by type.
        return $this->users->getUserByType($id,$type);
    }

    //add  'username',
    //'email',
    //'first_name',
    //'last_name'
    public function addUser($user){
        $return= [];

        if(!$this->validator->email($user['email'])){
            $return = array_merge($return, [
                'error_code' => 400028,
                'message' => 'Email not verified'
            ]);
        }

        if(!$this->validator->username($user['username'])){
            $return = array_merge($return, [
                'error_code' => 400028,
                'message' => 'Username not verified'
            ]);
        }

        //check username and email doest not exist.
        $check_mail = $this->users->checkEmail($user['email'],$user['user_type']);
        if(!is_null($check_mail)){
            $return = array_merge($return,[
                'error_code' => 204,
                'message' => 'Email already exist'
            ]);
        }

        $check_username = $this->users->checkUserName($user['username'],$user['user_type']);
        if(!is_null($check_username)){
            $return = array_merge($return,[
                'error_code' => 204,
                'message' => 'Username already exist'
            ]);
        }

        //if user validated
        if(empty(array_filter($return))){
            //add user
            //get user id
            $adduser_response = $this->users->addUser($user);

            $return = [
                'status' => 200,
                'id' => 17,
                'message' => $adduser_response
            ];

        }

        return $return;
    }
    public function updateUser($user){
        return $this->users->updateUser($user);
    }
    public function deleteUser($id){
        return $this->users->deleteUser($id);
    }
    public function getEmail($id){
        return $this->users->getEmail($id);
    }
    //@return user_id add user type para meter
    public function checkLoginName($username, $user_Type){
       //filter if login is email or username
       if($this->validator->email($username)){
           //check email if exist return id
           $return = $this->users->checkEmail($username, $user_Type);
            if(!is_null($return)){
                $is_disabled = $this->checkUserDisabled($return);
                if(!$is_disabled){
                    return [
                        'status' => 200,
                        'data' => $return
                    ];
                } else {
                    return [
                        'status' => 202,
                        'data' => $is_disabled
                    ];
                }
            } else {
                return [
                    'status' => 202,
                    'data' => "Email does not Exist"
                ];
            }
       }elseif($this->validator->username($username)){
           //check username if exist return id
           $return = $this->users->checkUserName($username,$user_Type);
           if(!is_null($return) ){
               $is_disabled = $this->checkUserDisabled($return);
               if(!$is_disabled){
                   return [
                       'status' => 200,
                       'data' => $return
                   ];
               } else {
                   return [
                       'status' => 202,
                       'data' => $is_disabled
                   ];
               }
           } else {
               return [
                   'status' => 202,
                   'data' => "Username does not exist"
               ];
           }
       } else{
           return [
               'status' => 202,
               'data' => "Invalid Username"
           ];
       }
    }
    public function forgotPassword($username,$user_Type){
        $this->checkLoginName($username,$user_Type);
    }
    public function addLoginAttempt($id){
        $this->users->addLoginAttempt($id);
    }
    public function lockAccount($id){
        $this->users->lockAccount($id);
    }
    public function resetLoginAttempt($id){
        $this->users->resetLoginAttempt($id);
    }
    public function exceedLoginAttempts($id){
        $attempts = $this->users->getLoginAttempts($id);
        //Get login attempts of the account.
        if($attempts >= 3){
            return false;
        } else {
            return true;
        }
    }
    public function checkEmail($email,$user_type){
        //check email if it exist
        $return =  $this->users->checkEmail($email,$user_type);

        if(is_null($return)){
            return [
                'error_code' => 204,
                'message' => 'Email does not exist'
            ];
        }
        return [
            'status' => 200,
            'user_id' => $return
        ];
    }

    public function checkUsername($username,$user_type){
        $return = $this->users->checkUserName($username,$user_type);
        if(is_null($return)){
            return [
                'error_code' => 204,
                'message' => 'Username does not exist'
            ];
        }

        return [
            'status' => 200,
            'user_id' => $return
        ];
    }
    //check user if enable to login.
    public function checkUserDisabled($id){
        if($this->users->accountActivated($id) == 0 ){
            //check if activated
            return "Account Inactive";
        } elseif($this->users->accountLocked($id) == 1){
            //check if locked
            return "Account Locked";
        } elseif($this->users->accountDeleted($id) == 1 ){
            //check if delete
            return "Account Deleted";
        } else {
            return false;
        }
    }
    //
    public function checkUserId($id){
        //check if user id exist
        $user = $this->users->getUser($id);
        dd(isset($user['id']));
        //check user id if
    }
    //Add access token to user table
    public function setAccessToken($access_token){
        return 0;
    }
    //Get access token of the user
    public function getAccessToken($user){
        return 0;
    }
}