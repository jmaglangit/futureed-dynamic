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

    // get common information
    public function getUser($id,$user_type = 'all'){
        $user =  User::select(
            'id'
            ,'username'
            ,'email'
            ,'password'
            ,'name'
            ,'user_type'
            ,'status');

        $user->where('id','=',$id);

        if($user_type <> 'all'){
            $user->where('user_type','=',$user_type);
        }

        return $user->first();
    }

    //get all details of the user
    public function getUserDetail($id,$user_type){
        return User::where('id','=',$id)
            ->where('user_type','=',$user_type)
            ->first();
    }


    public function addUser($user){

        try{
            User::insert([
                'username' => $user['username'],
                'email' => $user['email'],
                'name' => $user['first_name'] .' '.$user['last_name'],
                'user_type' => $user['user_type'],
                'confirmation_code' => $user['confirmation_code'],
                'confirmation_code_expiry' => $user['confirmation_code_expiry'],
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

    /**
     * @param $id
     * @throws Exception
     */
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

    public function getConfirmationCode($id)
    {

        return User::select('confirmation_code', 'confirmation_code_expiry')
            ->where('id', '=', $id)->first();
    }
    //update reset_code and reset_code_expiry
    public function updateResetCode($id,$code){
        try{
//            $user = User::find($id);
//            $user->reset_code =$code['confirmation_code'];
//            $user->reset_code_expiry=$code['confirmation_code_expiry'];
//            $user->save();

            User::where('id',$id)->update([
                'reset_code' => $code['confirmation_code'],
                'reset_code_expiry' => $code['confirmation_code_expiry']
            ]);

        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    //check id with password
    public function checkPassword($id,$password){

        return User::where('id',$id)
            ->where('password',$password)
            ->pluck('id');

    }
    
    //return only the username and the email
    public function getUsernameEmail($id){
       
        return User::select('username','email')
                    ->where('id','=',$id)->first();            
    }
    
    //update username and email
    
    public function updateUsernameEmail($id,$data){
        User::where('id','=',$id)
                     ->update(['username'=>$data['username'],
                               'email'=>$data['email']
                              ]);
    }
    
    
    //update username inactive || locked
    public function updateInactiveLock($id){
         User::where('id','=',$id)
                     ->update(['is_account_activated'=>1,
                               'is_account_locked'=>0,
                                'login_attempt' => 0,
                              ]);
        
    }






}