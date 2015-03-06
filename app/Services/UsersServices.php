<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 1:50 PM
 */

namespace App\Services;

use App\Futureed\Repository\Users\UsersRepositoryInterface;


class UsersServices {

    /**
     *
     */
    public function __construct(UsersRepositoryInterface $users){
        $this->users = $users;
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



}