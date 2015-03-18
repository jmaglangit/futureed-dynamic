<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/5/15
 * Time: 6:06 PM
 */
namespace FutureEd\Models\Repository\User;

use FutureEd\Models\Core\User;


class UserRepository implements UserRepositoryInterface{

    //TODO: filter all query by user_type.

    public function getUsers(){
        return User::all();
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
        return User::where('username','=',$username)->pluck('id');

    }

    public function checkEmail($email){

        //return user id
        return User::where('email','=',$email)->pluck('id');

    }

    public function getLoginAttempts($id){

        return User::select('login_attempt')->where('id','=',$id)->get();

    }

    public function accountActivated($id){

        return User::where('id','=',$id)->pluck('is_account_activated');

    }

    public function accountLocked($id){

        return User::where('id','=',$id)->pluck('is_account_locked');
    }

    public function accountDeleted($id){

        return User::where('id','=',$id)->pluck('is_account_deleted');

    }





}