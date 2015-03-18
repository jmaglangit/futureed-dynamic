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

    public function addUser($user){
        return $this->users->addUser($user);
    }

    public function updateUser($user){
        return $this->users->updateUser($user);
    }

    public function deleteUser($id){
        return $this->users->deleteUser($id);
    }

    //@return user_id
    public function checkLoginName($username){

       //filter if login is email or username
       if($this->validator->email($username)){

           //check email if exist return id
           $return = $this->users->checkEmail($username);

            if(!is_null($return)){

                return $this->checkUserEnabled($return);

            } else {

                return "Email does not exist";
            }

       }elseif($this->validator->username($username)){

           //check username if exist return id
           $return = $this->users->checkUserName($username);

           if(!is_null($return)){

               return $this->checkUserEnabled($return);

           } else {

               return "Username does not exist";
           }

       } else{

           return "Invalid";

       }
    }

    public function getLoginAttempts($id){

        $attempts = $this->users->getLoginAttempts($id);

        //Get login attempts of the account.
        if($attempts >= 3){

            return false;

        } else {

            return true;

        }

    }

    //check user if enable to login.
    public function checkUserEnabled($id){

        if($this->users->accountActivated($id) == 0 ){

            //check if activated
            return "Account DeActivated";

        } elseif($this->users->accountLocked($id) == 1){

            //check if locked
            return "Account Locked";

        } elseif($this->users->accountDeleted($id) == 1 ){

            //check if delete
            return "Account Deleted";

        } else {

            return true;
        }



    }






}