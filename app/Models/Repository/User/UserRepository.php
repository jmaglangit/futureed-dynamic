<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/5/15
 * Time: 6:06 PM
 */
namespace FutureEd\Models\Repository\Users;

use FutureEd\Models\Core\User;
use FutureEd\Models\Repository\User\UserRepositoryInterface;


class UserRepository implements UserRepositoryInterface{

    public function getUsers(){
        return 0;
    }

    public function getUser($id){
        return 0;
    }

    public function addUser($user){
        //
        try{
            \DB::table('students')->insert(
                [
                    'first_name' => '',
                    'last_name' => '',
                    'gender' =>'',
                    'birth_date' => '',
                    'avatar_id' => '',
                    'password_image_id' => '',
                    'school_code' =>'',
                    'level_code' =>'',
                    'points' =>'',
                    'point_level_id' =>'',
                    'learning_style_id' =>'',
                    'status' => '',
                    'created_by_id' => '',
                    'created_at' => '',
                ]
            );
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
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
        return User::select('id')
            ->where('username','=',$username)->get();
    }

    public function checkEmail($email){
        //return user id

        return User::select('id')
            ->where('email','=',$email)->get();
    }

}