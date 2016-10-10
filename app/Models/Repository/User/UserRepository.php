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

        DB::beginTransaction();

        try {

            $response = User::all();

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * Get common information
     * @param $id
     * @param string $user_type
     * @return mixed
     */
    public function getUser($id,$user_type = 'all'){

        DB::beginTransaction();

        try {

            $user = User::select(
                'id'
                , 'username'
                , 'email'
                , 'new_email'
                , 'password'
                , 'name'
                , 'user_type'
                , 'curriculum_country'
                , 'status')->where('id', $id);


            if ($user_type <> 'all') {
                $user->where('user_type', $user_type);
            }

            $response = $user->first();

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * Get all details of the user
     * @param $id
     * @param $user_type
     * @return mixed
     */
    public function getUserDetail($id,$user_type){

        DB::beginTransaction();

        try {

            $response = User::where('id', '=', $id)
                ->where('user_type', '=', $user_type)
                ->first();

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }


	/**
     * @param $user
     * @return string|static
     */
    public function addUser($user){

        DB::beginTransaction();

        try {

            $response = User::create([
                'username' => $user['username'],
                'email' => $user['email'],
                'name' => $user['first_name'] . ' ' . $user['last_name'],
                'user_type' => $user['user_type'],
                'password' => (isset($user['password'])) ? sha1($user['password']) : null,
                'status' => (isset($user['status'])) ? ($user['status']) : 'Enabled',
                'is_account_activated' => (isset($user['is_account_activated'])) ? $user['is_account_activated'] : NULL,
                'confirmation_code' => (isset($user['confirmation_code'])) ? $user['confirmation_code'] : NULL,
                'confirmation_code_expiry' => (isset($user['confirmation_code_expiry'])) ? $user['confirmation_code_expiry'] : NULL,
                'created_by' => 1,
                'updated_by' => 1,
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;

    }

	/**
     * @param $id
     * @param $data
     * @return \Illuminate\Support\Collection|null|string|static
     */
    public function updateUser($id, $data) {

        DB::beginTransaction();

        try {

			$user = User::find($id);
			
			$user->update($data);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

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

        DB::beginTransaction();

        try {

            $response = User::where('username', '=', $username)
                ->where('user_type', '=', $user_type)->pluck('id');

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * @param $email
     * @param $user_type
     * @return mixed
     */
    public function checkEmail($email,$user_type){

        DB::beginTransaction();

        try {

            $response = User::where('email', '=', $email)
                ->where('user_type', '=', $user_type)->pluck('id');

        } catch (\Exception $e) {

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
    public function getLoginAttempts($id){

        DB::beginTransaction();

        try{

            $response = User::where('id','=',$id)->pluck('login_attempt');

        } catch (\Exception $e) {

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
    public function accountActivated($id){

        DB::beginTransaction();

        try{

            $response = User::where('id','=',$id)->pluck('is_account_activated');

        } catch (\Exception $e) {

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
    public function accountLocked($id){

        DB::beginTransaction();

        try{

            $response = User::where('id','=',$id)->pluck('is_account_locked');

        } catch (\Exception $e) {

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
    public function accountDeleted($id){

        DB::beginTransaction();

        try{

            $response = User::where('id','=',$id)->pluck('is_account_deleted');

        } catch (\Exception $e) {

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
    public function accountStatus($id){

        DB::beginTransaction();

        try{

		    $response = User::where('id','=',$id)->pluck('status');

        } catch (\Exception $e) {

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
     * @throws Exception
     */
    public function addLoginAttempt($id) {

        DB::beginTransaction();

        try {

            $attempt = $this->getLoginAttempts($id);

            $attempt = $attempt + 1;

            $user = User::find($id);

            $user->login_attempt = $attempt;

            $response = $user->save();

        } catch (\Exception $e) {

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
     * @throws Exception
     */
    public function resetLoginAttempt($id){

        DB::beginTransaction();

        try {

            $user = User::find($id);

            $user->login_attempt = 0;

            $response = $user->save();

        } catch (\Exception $e) {

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
     * @throws Exception
     */
    public function lockAccount($id){

        DB::beginTransaction();

        try{

            $user = User::find($id);

            $user->is_account_locked = 1;

            $response = $user->save();
            
        } catch (\Exception $e) {

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
    public function getEmail($id){

        DB::beginTransaction();

        try{

            $response =  User::where('id','=',$id)->pluck('email');

        } catch (\Exception $e) {

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
    public function getConfirmationCode($id)
    {

        DB::beginTransaction();

        try{

            $response = User::select('confirmation_code', 'confirmation_code_expiry')
            ->where('id', '=', $id)->first();

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Update reset_code and reset_code_expiry
     * @param $id
     * @param $code
     * @return bool
     * @throws Exception
     */
    public function updateResetCode($id,$code){

        DB::beginTransaction();

        try{

           $response =  User::where('id',$id)->update([
                'reset_code' => $code['confirmation_code'],
                'reset_code_expiry' => $code['confirmation_code_expiry']
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * Check id with password
     * @param $id
     * @param $password
     * @return mixed
     */
    public function checkPassword($id,$password){

        DB::beginTransaction();

        try {

            $response = User::where('id', $id)
                ->where('password', $password)
                ->pluck('id');

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * Return only the username and the email
     * @param $id
     * @return mixed
     */
    public function getUsernameEmail($id){

        DB::beginTransaction();

        try {

            $response = User::select('username', 'email', 'new_email')
                ->where('id', '=', $id)->first();

        }catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Update username and email
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateUsernameEmail($id,$data){

        DB::beginTransaction();

        try{

        $response = User::where('id','=',$id)
                     ->update(['username'=>$data['username'],
                               'email'=>$data['email']
                              ]);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Update username inactive or locked
     * @param $id
     * @return bool
     */
    public function updateInactiveLock($id){

        DB::beginTransaction();

        try{

         $response = User::where('id','=',$id)
                     ->update(['is_account_activated'=>1,
                               'is_account_locked'=>0,
                               'login_attempt' => 0,
                               'confirmation_code' => null,
                               'confirmation_code_expiry' => null,
                               'reset_code' => null,
                               'reset_code_expiry' => null
                              ]);

        } catch (\Exception $e) {

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
    public function isActivated($id){

        DB::beginTransaction();

        try {

            $response = User::where('id', '=', $id)
                ->pluck('is_account_activated');

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * @param $id
     * @param $code
     * @return bool
     * @throws Exception
     */
    public function updateConfirmationCode($id,$code){

        DB::beginTransaction();

        try{

            $response = User::where('id',$id)->update([
                'confirmation_code' => $code['confirmation_code'],
                'confirmation_code_expiry' => $code['confirmation_code_expiry']
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * @param $id
     * @param $password
     * @return bool
     * @throws Exception
     */
    public function updatePassword($id,$password){

        DB::beginTransaction();

        try{

            $response = User::where('id',$id)->update([
                'password' => $password
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;

    }

    /**
     * @param $id
     * @param $username
     * @return bool
     * @throws Exception
     */
    public function updateUsername($id,$username){

        DB::beginTransaction();

         try{

           $response = User::where('id',$id)->update([
                'username' => $username['username'],
                'name' => $username['name'],
                'email'=>$username['email']
            ]);

        } catch (\Exception $e) {

             DB::rollback();

             $this->errorLog($e->getMessage());

             return false;
         }

        DB::commit();

        return $response;
    }

    /**
     * @param $id
     * @param $new_email
     * @return bool
     * @throws Exception
     */
    public function addNewEmail($id,$new_email){

        DB::beginTransaction();

        try{

            $response = User::where('id',$id)->update([
                'new_email' => $new_email
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * @param $new_email
     * @param $user_type
     * @return mixed
     */
    public function checkNewEmailExist($new_email,$user_type){

        DB::beginTransaction();

        try {

            $response = User::where('new_email', '=', $new_email)
                ->where('user_type', '=', $user_type)->pluck('id');

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * @param $user_id
     * @param $new_email
     * @return bool
     * @throws Exception
     */
    public function updateToNewEmail($user_id,$new_email){

        DB::beginTransaction();

         try{

            $response = User::where('id',$user_id)->update([
                'new_email' => '',
                'email' => $new_email,
                'email_code' =>'',
                'email_code_expiry' => ''
            ]);

        } catch (\Exception $e) {

             DB::rollback();

             $this->errorLog($e->getMessage());

             return false;
         }

        DB::commit();

        return $response;
    }

    /**
     * @param $id
     * @param $code
     * @return bool
     * @throws Exception
     */
    public function updateEmailCode($id,$code){

        DB::beginTransaction();

        try{

            $response = User::where('id',$id)->update([
                'email_code' => $code['confirmation_code'],
                'email_code_expiry' => $code['confirmation_code_expiry']
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }


    /**
     * @param $id
     * @param $status
     * @return bool
     * @throws Exception
     */
    public function updateStatus($id,$status){

        DB::beginTransaction();

        try{

            $response = User::where('id',$id)->update([
                'status' => $status,
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Add Registration Token.
     * @param $id
     * @param $registration_token
     * @return bool
     * @throws Exception
     */
	public function addRegistrationToken($id,$registration_token){

        DB::beginTransaction();

		try{

			$response = User::where('id',$id)->update([
				'registration_token' => $registration_token
			]);

		} catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
	}

	/**
	 * Get Registration Token.
	 * @param $id
	 * @return mixed
	 */
	public function getRegistrationToken($id){

        DB::beginTransaction();

        try {

            $response = User::select('registration_token')
                ->where('id', $id);
        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
	}

	/**
	 * Remove registration token.
	 * @param $id
	 * @return mixed
	 */
	public function deleteRegistrationToken($id){

        DB::beginTransaction();

        try {

            $response = User::where('id', $id)->update([
                'registration_token' => NULL
            ]);

        } catch (\Exception $e) {

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
    public function getFacebookId($id){

        DB::beginTransaction();

        try {

            $response = User::where('id', $id)->pluck('facebook_app_id');

        } catch (\Exception $e) {

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
    public function getGoogleId($id){

        DB::beginTransaction();

        try {

            $response = User::where('id', $id)->pluck('google_app_id');

        } catch (\Exception $e) {

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
    public function getSessionToken($id){

        DB::beginTransaction();

        try {

            $response = User::select('session_token', 'last_activity')->find($id);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
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

        DB::beginTransaction();

        try {

            $response = User::where('id', $id)->pluck('impersonated_by');

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Get user background image.
     * @param $user_type
     * @param $id
     * @return mixed
     */
    public function getBackgroundImage($user_type, $id){

        return User::with('background_image')->where('user_type',$user_type)->find($id);
    }

    /**
     * Update user background image.
     * @param $user_id
     * @param $background_image_id
     * @return bool
     */
    public function updateBackgroundImage($user_id,$background_image_id){

        DB::beginTransaction();

        try {

            $response = User::whereId($user_id)->update([
                'background_image_id' => $background_image_id
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Get Curriculum Country
     * @param $user_id
     */
    public function getCurriculumCountry($user_id){

        return User::find($user_id)->curriculum_country;
    }













}