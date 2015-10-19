<?php namespace FutureEd\Models\Repository\User;

use Carbon\Carbon;
use FutureEd\Models\Core\User;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;


class UserRepository implements UserRepositoryInterface {


    use LoggerTrait;

	/**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getUsers(){
        return User::all();
    }

    // get common information
	/**
     * @param $id
     * @param string $user_type
     * @return mixed
     */
    public function getUser($id,$user_type = 'all'){
        $user =  User::select(
            'id'
            ,'username'
            ,'email'
            ,'new_email'
            ,'password'
            ,'name'
            ,'user_type'
            ,'status')->where('id',$id);



        if($user_type <> 'all'){
            $user->where('user_type',$user_type);
        }

        return $user->first();
    }

    //get all details of the user
	/**
     * @param $id
     * @param $user_type
     * @return mixed
     */
    public function getUserDetail($id,$user_type){
        return User::where('id','=',$id)
            ->where('user_type','=',$user_type)
            ->first();
    }


	/**
     * @param $user
     * @return string|static
     */
    public function addUser($user){

        try{

            return User::create([
                'username' => $user['username'],
                'email' => $user['email'],
                'name' => $user['first_name'] .' '.$user['last_name'],
                'user_type' => $user['user_type'],
                'password' => (isset($user['password'])) ? sha1($user['password']) : null,
                'status' => (isset($user['status'])) ? ($user['status']) : 'Enabled',
                'is_account_activated' => (isset($user['is_account_activated'])) ? $user['is_account_activated'] : NULL,
                'confirmation_code' => (isset($user['confirmation_code'])) ? $user['confirmation_code'] : NULL,
                'confirmation_code_expiry' => (isset($user['confirmation_code_expiry'])) ? $user['confirmation_code_expiry'] : NULL,
                'created_by' => 1,
                'updated_by' => 1,
            ]);

        }catch(Exception $e){
            return $e->getMessage();
        }

    }

	/**
     * @param $id
     * @param $data
     * @return \Illuminate\Support\Collection|null|string|static
     */
    public function updateUser($id, $data) {
        try {
		
			$user = User::find($id);
			
			$user->update($data);
			
		} catch(Exception $e) {
		
			return $e->getMessage();
			
		}
		
		return $user;
    }

	/**
     * @param $id
     * @return int
     */
    public function deleteUser($id){
        return 0;
    }

	/**
     * @param $username
     * @param $user_type
     * @return mixed
     */
    public function checkUserName($username,$user_type){

        //return user id
        return User::where('username','=',$username)
            ->where('user_type','=',$user_type)->pluck('id');

    }

	/**
     * @param $email
     * @param $user_type
     * @return mixed
     */
    public function checkEmail($email,$user_type){

        //return user id
        return User::where('email','=',$email)
            ->where('user_type','=',$user_type)->pluck('id');

    }

	/**
     * @param $id
     * @return mixed
     */
    public function getLoginAttempts($id){

        return User::where('id','=',$id)->pluck('login_attempt');

    }

	/**
     * @param $id
     * @return mixed
     */
    public function accountActivated($id){

        return User::where('id','=',$id)->pluck('is_account_activated');

    }

	/**
     * @param $id
     * @return mixed
     */
    public function accountLocked($id){

        return User::where('id','=',$id)->pluck('is_account_locked');
    }

	/**
     * @param $id
     * @return mixed
     */
    public function accountDeleted($id){

        return User::where('id','=',$id)->pluck('is_account_deleted');

    }

    /**
     * @param $id
     * @return mixed
     */
    public function accountStatus($id){

		return User::where('id','=',$id)->pluck('status');

	}

	/**
     * @param $id
     * @throws Exception
     */
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

	/**
     * @param $id
     * @throws Exception
     */
    public function lockAccount($id){
        try{

            $user = User::find($id);
            $user->is_account_locked = 1;
            $user->save();
            
        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

	/**
     * @param $id
     * @return mixed
     */
    public function getEmail($id){

        return User::where('id','=',$id)->pluck('email');

    }

    //set access token of the user
	/**
     * @param $access_token
     */
    public function setAccessToken($access_token){

    }

    //get access token of the user
	/**
     * @param $user
     */
    public function getAccessToken($user){

    }

	/**
     * @param $id
     * @return mixed
     */
    public function getConfirmationCode($id)
    {

        return User::select('confirmation_code', 'confirmation_code_expiry')
            ->where('id', '=', $id)->first();
    }

    //update reset_code and reset_code_expiry
	/**
     * @param $id
     * @param $code
     * @throws Exception
     */
    public function updateResetCode($id,$code){
        try{

            User::where('id',$id)->update([
                'reset_code' => $code['confirmation_code'],
                'reset_code_expiry' => $code['confirmation_code_expiry']
            ]);

        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    //check id with password
	/**
     * @param $id
     * @param $password
     * @return mixed
     */
    public function checkPassword($id,$password){

        return User::where('id',$id)
            ->where('password',$password)
            ->pluck('id');

    }
    
    //return only the username and the email
	/**
     * @param $id
     * @return mixed
     */
    public function getUsernameEmail($id){
       
        return User::select('username','email','new_email')
                    ->where('id','=',$id)->first();            
    }
    
    //update username and email

	/**
     * @param $id
     * @param $data
     */
    public function updateUsernameEmail($id,$data){
        User::where('id','=',$id)
                     ->update(['username'=>$data['username'],
                               'email'=>$data['email']
                              ]);
    }
    
    
    //update username inactive || locked
	/**
     * @param $id
     */
    public function updateInactiveLock($id){
         User::where('id','=',$id)
                     ->update(['is_account_activated'=>1,
                               'is_account_locked'=>0,
                               'login_attempt' => 0,
                               'confirmation_code' => null,
                               'confirmation_code_expiry' => null,
                               'reset_code' => null,
                               'reset_code_expiry' => null
                              ]);
        
    }

	/**
     * @param $id
     * @return mixed
     */
    public function isActivated($id){
        
         return User::where('id','=',$id)
                     ->pluck('is_account_activated');
                     
    }

	/**
     * @param $id
     * @param $code
     * @throws Exception
     */
    public function updateConfirmationCode($id,$code){
        try{

            User::where('id',$id)->update([
                'confirmation_code' => $code['confirmation_code'],
                'confirmation_code_expiry' => $code['confirmation_code_expiry']
            ]);

        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

	/**
     * @param $id
     * @param $password
     * @throws Exception
     */
    public function updatePassword($id,$password){

        try{

            User::where('id',$id)->update([
                'password' => $password
            ]);

        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }

    }

	/**
     * @param $id
     * @param $username
     * @throws Exception
     */
    public function updateUsername($id,$username){

         try{

            User::where('id',$id)->update([
                'username' => $username['username'],
                'name' => $username['name'],
                'email'=>$username['email']
            ]);

        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }

    }

	/**
     * @param $id
     * @param $new_email
     * @throws Exception
     */
    public function addNewEmail($id,$new_email){

        try{

            User::where('id',$id)->update([
                'new_email' => $new_email
            ]);

        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }


    }

	/**
     * @param $new_email
     * @param $user_type
     * @return mixed
     */
    public function checkNewEmailExist($new_email,$user_type){

         return User::where('new_email','=',$new_email)
            ->where('user_type','=',$user_type)->pluck('id');


    }

	/**
     * @param $user_id
     * @param $new_email
     * @throws Exception
     */
    public function updateToNewEmail($user_id,$new_email){


         try{

            User::where('id',$user_id)->update([
                'new_email' => '',
                'email' => $new_email,
                'email_code' =>'',
                'email_code_expiry' => ''
            ]);

        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }


    }

	/**
     * @param $id
     * @param $code
     * @throws Exception
     */
    public function updateEmailCode($id,$code){
        try{

            User::where('id',$id)->update([
                'email_code' => $code['confirmation_code'],
                'email_code_expiry' => $code['confirmation_code_expiry']
            ]);

        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }


	/**
     * @param $id
     * @param $status
     * @throws Exception
     */
    public function updateStatus($id,$status){
        
        try{

            User::where('id',$id)->update([
                'status' => $status,
            ]);

        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

	/**
	 * Add Registration Token.
	 * @param $id
	 * @param $registration_token
	 * @throws Exception
	 */
	public function addRegistrationToken($id,$registration_token){

		try{

			User::where('id',$id)->update([
				'registration_token' => $registration_token
			]);

		} catch (Exception $e){

			throw new Exception($e->getMessage());
		}
	}

	/**
	 * Get Registration Token.
	 * @param $id
	 * @return mixed
	 */
	public function getRegistrationToken($id){

		return User::select('registration_token')
			->where('id',$id);
	}

	/**
	 * Remove registration token.
	 * @param $id
	 * @return mixed
	 */
	public function deleteRegistrationToken($id){

		return User::where('id',$id)->update([
			'registration_token' => NULL
		]);
	}

	/**
     * @param $id
     * @return mixed
     */
    public function getFacebookId($id){

        return User::where('id',$id)->pluck('facebook_app_id');
    }


	/**
     * @param $id
     * @return mixed
     */
    public function getGoogleId($id){

        return User::where('id',$id)->pluck('google_app_id');
    }

	/**
     * @param $id
     * @return mixed
     */
    public function getSessionToken($id){

        return User::select('session_token','last_activity')->find($id);

    }

	/**
     * @param $data
     * @return bool
     */
    public function updateSessionToken($data){

        DB::beginTransaction();

        try{

            $response = User::where('id',$data['user_id'])
                ->update([
                    'session_token' => $data['session_token'],
                    'last_activity' => Carbon::now()
                ]);

        }catch (\Exception $e){

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;

    }


	/**
     * @param $id
     * @return bool
     */
    public function emptySessionToken($id){

        DB::beginTransaction();

        try{

            $response = User::where('id',$id);

            $response = $response
                ->update([
                    'session_token' => NULL
                ]);
        }catch(\Exception $e){

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }


	/**
     * @param $id
     * @param $impersonator
     * @return bool
     */
    public function enableImpersonate($id, $impersonator){

        DB::beginTransaction();

        try{

            $response = User::where('id',$id)
                ->update([
                    'impersonate' => 1,
                    'impersonated_by' => $impersonator
                ]);

        }catch (\Exception $e){


            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * @param $id
     * @return bool
     */
    public function disabledImpersonate($id){

        DB::beginTransaction();

        try{

            $response = User::where('id',$id)
                ->update([
                    'impersonate' => NULL,
                    'impersonated_by' => NULL
                ]);

        }catch (\Exception $e){


            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * @param $id
     * @return mixed
     */
    public function getImpersonator($id){

        return User::where('id',$id)->pluck('impersonated_by');
    }













}