<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 1:50 PM
 */

namespace FutureEd\Services;

use FutureEd\Models\Repository\Users\UsersRepositoryInterface;
use FutureEd\Models\Repository\Validator\ValidatorRepositoryInterface;


class UsersServices {

    /**
     *
     */
    public function __construct(UsersRepositoryInterface $users,ValidatorRepositoryInterface $validator){
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

   public function checkLoginName($username){
       //filter if login is email or username
       if($this->validator->email($username)){
           //check email if exist return id
           $return = $this->users->checkEmail($username);
       }elseif($this->validator->username($username)){
           //check username if exist return id
           $return = $this->users->checkUserName($username);
       }
       return $return;
   }






}