<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/5/15
 * Time: 6:06 PM
 */
namespace FutureEd\Models\Repository\User;

use FutureEd\Models\Core\User;
use League\Flysystem\Exception;


class UserRepository implements UserRepositoryInterface{

    //TODO: filter all query by user_type.

    public function getUsers(){
        return User::all();
    }

    public function getUser($id){
        return User::where('id','=',$id)->first();
    }

    public function getUserByType($id,$type){
        return User::where('id','=',$id)
            ->where('user_type','=',$type)
            ->get();
    }

    public function addUser($user){

        try{
            User::insert([
                'username' => $user['username'],
                'email' => $user['email'],
                'name' => $user['first_name'] .' '.$user['last_name'],
                'user_type' => $user['user_type'],
                'created_by' => 1,
                'updated_by' => 1,
            ]);

        }catch(Exception $e){
            return $e->getMessage();
        }
        return true;
    }

    public function updateUser($user){
        return 0;
    }

    public function deleteUser($id){
        return 0;
    }

    public function checkUserName($username,$user_type){

        //return user id
        return User::where('username','=',$username)
            ->where('user_type','=',$user_type)->pluck('id');

    }

    public function checkEmail($email,$user_type){

        //return user id
        return User::where('email','=',$email)
            ->where('user_type','=',$user_type)->pluck('id');

    }

    public function getLoginAttempts($id){

        return User::where('id','=',$id)->pluck('login_attempt');

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

    public function addLoginAttempt($id){
        $attempt = $this->getLoginAttempts($id);

        $attempt = $attempt + 1;
        try{

            $user = User::find($id);

            $user->login_attempt = $attempt;

            $user->save();

        }catch (Exception $e){

            throw new Exception ($e->getMessage());

        }
    }

    public function resetLoginAttempt($id){
        try{
            $user = User::find($id);
            $user->login_attempt = 0;
            $user->save();
        } catch (Exception $e){
            throw new Exception ($e->getMessage());
        }
    }

    public function lockAccount($id){
        try{
            $user = User::find($id);
            $user->is_account_locked = 1;
            $user->save();
        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function getEmail($id){

        return User::where('id','=',$id)->pluck('email');

    }

    //set access token of the user
    public function setAccessToken($access_token){

    }

    //get access token of the user
    public function getAccessToken($user){

    }






}