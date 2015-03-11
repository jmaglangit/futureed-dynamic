<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/5/15
 * Time: 6:06 PM
 */
namespace FutureEd\Models\Repository\Users;

use FutureEd\Models\Core\Users;


class UsersRepository implements UsersRepositoryInterface{

    public function getUsers(){
        return 0;
    }

    public function getUser($id){
        return 0;
    }

    public function addUser($user){
        return 0;
    }

    public function updateUser($user){
        return 0;
    }

    public function deleteUser($id){
        return 0;
    }

    public function checkUserName($username){
        //return user id
        return Users::select('id')
            ->where('username','=',$username)->get();
    }

    public function checkEmail($email){
        //return user id

        return Users::select('id')
            ->where('email','=',$email)->get();
    }

}