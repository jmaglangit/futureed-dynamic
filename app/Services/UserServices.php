<?php namespace FutureEd\Services;

use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Models\Repository\Validator\ValidatorRepositoryInterface;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;

class UserServices {
    /**
     *
     */
    public function __construct(
        UserRepositoryInterface $users,
        ValidatorRepositoryInterface $validator,
        CodeGeneratorServices $code,StudentRepositoryInterface $student){
        $this->users = $users;
        $this->validator = $validator;
        $this->code = $code;
        $this->student= $student;
    }
    public function getUsers(){
        return $this->users->getUsers();
    }
    public function getUser($id,$user_type){

        return $this->users->getUser($id,$user_type);
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
                'message' => 'Email invalid'
            ]);
        }

        if(!$this->validator->username($user['username'])){
            $return = array_merge($return, [
                'error_code' => 400028,
                'message' => 'Username invalid'
            ]);
        }

        //check username and email doest not exist.
        $check_mail = $this->users->checkEmail($user['email'],$user['user_type']);
        if(!is_null($check_mail)){
            $return = array_merge($return,[
                'error_code' => 2200,
                'message' => 'Email already exist'
            ]);
        }

        $check_username = $this->users->checkUserName($user['username'],$user['user_type']);
        if(!is_null($check_username)){
            $return = array_merge($return,[
                'error_code' => 2201,
                'message' => 'Username already exist'
            ]);
        }

        //if user validated
        if(empty(array_filter($return))){
            //add user

            //append registration code with date expiry
            $user = array_merge($user, $this->code->getCodeExpiry());


            //get user id
            $adduser_response = $this->users->addUser($user);

            $user_id = $this->users->checkEmail($user['email'],$user['user_type']);

            $return = [
                'status' => 200,
                'id' => $user_id,
                'message' => $adduser_response,
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
    public function checkLoginName($username, $user_type){
       //filter if login is email or username
       if($this->validator->email($username)){
           //check email if exist return id
           $return = $this->users->checkEmail($username, $user_type);


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
                    'data' => 2002
                ];
            }
       }elseif($this->validator->username($username)){
           //check username if exist return id
           $return = $this->users->checkUserName($username,$user_type);


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
                   'data' => 2018
               ];
           }
       } else{
           return [
               'status' => 202,
               'data' => "Invalid Username"
           ];
       }
    }

    //match user with the password
    public function checkPassword($id, $password){

        //match password
        $return = $this->users->checkPassword($id,$password);

        if(is_null($return)){
            return false;
        }

        return [
            'status' => 200,
            'id' => $return
        ];


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
        $error_msg = config('futureed-error.error_messages');
        //check email if it exist
        $return =  $this->users->checkEmail($email,$user_type);

        if(is_null($return)){
            return false;
        }
        return [
            'status' => 200,
            'user_id' => $return
        ];
    }

    public function checkUsername($username,$user_type){
        $error_msg = config('futureed-error.error_messages');
        $return = $this->users->checkUserName($username,$user_type);

        if(is_null($return)){
            return false;
        }

        return [
            'status' => 200,
            'user_id' => $return
        ];
    }
    //check user if enable to login.
    public function     checkUserDisabled($id){
        if($this->users->accountActivated($id) == 0 ){
            //check if activated
            return 2230;
        } elseif($this->users->accountLocked($id) == 1){
            //check if locked
            return 2014;
        } elseif($this->users->accountDeleted($id) == 1 ){
            //check if delete
            return 2020;
        } else {
            return false;
        }
    }
    //
    public function checkUserId($id){
        //check if user id exist

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

    //get user confirmation code
    public function getConfirmationCode($id){
        
        return $this->users->getConfirmationCode($id);
    }

    //get userDetail Response
    public function getUserDetails($user_id){
      
        $user_details = $this->users->getUser($user_id,'all');
        $return =['username'=>$user_details['username'],
                  'user_type'=>$user_details['user_type'],
                  'email'=>$user_details['email'],
                  'new_email' => $user_details['new_email'],
                  'status' => $user_details['status']];

        return $return;
    }

    //update reset_code and reset_code_expiry
    public function setResetCode($id,$code){
       
        $this->users->updateResetCode($id,$code);
    }

    //get all user Details
    public function getUserDetail($id,$user_Type){
       
        $return =$this->users->getUserDetail($id,$user_Type);
        return $return;
    }
    
    //check if reset code expired
    public function checkCodeExpiry($reset_code_expiry){

        $date = date('Y-m-d H:i:s');
        
        if($date>$reset_code_expiry){
            return true;
        }
        else{
            return false;
        }
    }
    
    
    //get username and email
    public function getUsernameEmail($id){
      
        return $this->users->getUsernameEmail($id);
    }
    
    //update user username and email
    public function updateUsernameEmail($id,$data){
       
        $this->users->updateUsernameEmail($id,$data);
    }
    
    //get Email
    public function getIdByEmail($email,$user_type){
        
        $return = $this->users->checkEmail($email,$user_type);
        if(is_null($return)){
            return [
                'status' => 202,
                'data' => 'Email does not exist'
            ];
        }

        return [
            'status' => 200,
            'data' => $return
        ];
    }
    
     //update user inactive and locked
    public function updateInactiveLock($id){
        
        $this->users->updateInactiveLock($id);
    }
    
    
    //check if account activated
    
    public function isActivated($id){
        
        return $this->users->isActivated($id);
    }
    public function updateConfirmationCode($id,$code){

    $this->users->updateConfirmationCode($id,$code);
    }

    public function updatePassword($id,$password){

    $this->users->updatePassword($id,$password);
    }


    public function updateUsername($id,$username){

        $this->users->updateUsername($id,$username);
    }

    public function addNewEmail($id,$new_email){

        $this->users->addNewEmail($id,$new_email);
    }

    public function checkNewEmailExist($new_email,$user_type){

        return $this->users->checkNewEmailExist($new_email,$user_type);
    }

    public function updateToNewEmail($user_id,$new_email){

        $this->users->updateToNewEmail($user_id,$new_email);

    }

    public function updateEmailCode($id,$code){

        $this->users->updateEmailCode($id,$code);
    }

    public function updateStatus($id,$status){

        $this->users->updateStatus($id,$status);
    }

    

}