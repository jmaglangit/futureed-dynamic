<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 11:21 AM
 */
namespace FutureEd\Models\Repository\Admin;

use FutureEd\Models\Core\Admin;

class AdminRepository implements  AdminRepositoryInterface {

	use LoggerTrait;

	/**
	 * Get list of Administrators
	 *
	 * @param int limit
	 *
	 * @return array
	 */
	public function getAdmins($criteria = array(), $limit = 0, $offset = 0) {

		DB::beginTransaction();

		try{
			//get list of administrators username, email, roles
			$admins = new Admin();

			$count = 0;

			if(count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $admins->count();

			} else {

				if(count($criteria) > 0) {
					if(isset($criteria['email'])) {
						$admins = $admins->email($criteria['email']);
					}

					if(isset($criteria['username'])) {
						$admins = $admins->username($criteria['username']);
					}

					if(isset($criteria['role'])) {
						$admins = $admins->role($criteria['role']);
					}
				}

				$count = $admins->count();

				if($limit > 0 && $offset >= 0) {
					$admins = $admins->offset($offset)->limit($limit);;
				}

			}

			$admins = $admins->orderBy('created_at', 'asc');

			$response = ['total' => $count, 'records' => $admins->with('user')->get()->toArray()];

		}catch (\Exception $e){
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function getAdmin($id,$role='Admin') {

		DB::beginTransaction();

		try{
			$response = Admin::with('user')->role($role)->find($id);
				
		}catch (\Exception $e){
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * Get Admin information.
	 * @param $id
	 */
	public function getAdminDetail($id){

		DB::beginTransaction();

		try{
			$response = Admin::with('user')->find($id);

		}catch (\Exception $e){
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function addAdmin($data) {

		DB::beginTransaction();

		try {
			$response = Admin::create($data);

		} catch(\Exception $e) {
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;

		}

		DB::commit();

		return $response;
	}

	public function updateAdmin($id, $data) {

		DB::beginTransaction();

		try {
		
			$admin = Admin::find($id);

			$response = $admin->update($data);

		} catch(\Exception $e) {
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;

		}

		DB::commit();
		
		return $response;
	}

	public function deleteAdmin($id) {

		DB::beginTransaction();

		try {
			$admin = Admin::find($id);

			if($admin) {
				$is_deleted = $admin->delete();

				$response = $is_deleted ? $admin : FALSE;
			} else {
				$response = FALSE;
			}

		} catch(\Exception $e) {
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;

		}

		DB::commit();

		return $response;
	}

	public function getAdminId($user_id){

		DB::beginTransaction();

		try{
			$response = Admin::where('user_id','=',$user_id)->pluck('id');

		} catch(\Exception $e) {
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function getAdminUserId($id){

		DB::beginTransaction();

		try{
			$response = Admin::find($id)->user_id;

		} catch(\Exception $e){
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function verifyAdminId($id){

		DB::beginTransaction();

		try{
			$response = Admin::select('id','user_id')->where('id','=',$id)->first();

		} catch(\Exception $e){
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function canDelete() {

		DB::beginTransaction();

		try{
			$admins = Admin::all();
			$response = $admins->count() > config('futureed.admin_delete_threshold');


		} catch(\Exception $e){
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Admin role
	 * @param $id
	 */
	public function getAdminRole($id){

		DB::beginTransaction();

		try{
			$response = Admin::where('id','=',$id)->pluck('admin_role');

		} catch(\Exception $e){
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

}