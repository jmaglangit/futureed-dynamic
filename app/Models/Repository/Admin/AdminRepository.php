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

    /**
     * Get list of Administrators
     *
     * @param int limit
     *
     * @return array
     */
    public function getAdmins($criteria = array(), $limit = 0, $offset = 0) {

        //get list of administrators username, email, roles
        /*
$admin = new Admin();

        $admin = $admin->with('user')->paginate($limit);

        $paginator = [
            'currentPage' => $admin->currentPage(),
            'lastPage' => $admin->lastPage(),
            'perPage' => $admin->perPage(),
            'hasMorePages' => $admin->hasMorePages(),
            'nextPageUrl' => $admin->nextPageUrl(),
            'previousPageUrl' => $admin->previousPageUrl(),
            'total' => $admin->total(),
            'count' => $admin->count()
        ];

        return [
            'paginator' => $paginator,
            'records' => $admin->items()
        ];
*/

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
		
		$admins = $admins->orderBy('first_name', 'asc');
		
		return ['total' => $count, 'records' => $admins->with('user')->get()->toArray()];

    }

    public function getAdmin($id) {

        return Admin::find($id);

    }

    public function addAdmin($data) {
		try {
		
			$admin = Admin::create($data);
						
		} catch(Exception $e) {
		
			return $e->getMessage();
			
		}
		
		return $admin;
    }

    public function updateAdmin($id, $data) {
		try {
		
			$admin = Admin::find($id);
			
			$admin->update($data);
			
		} catch(Exception $e) {
		
			return $e->getMessage();
			
		}
		
		return $admin;
    }
    
    public function deleteAdmin($id) {
		try {
		
			$admin = Admin::find($id);
			
			if($admin) {
				$is_deleted = $admin->delete();
				
				return $is_deleted ? $admin : FALSE;
			} else {
				return FALSE;
			}
			
		} catch(Exception $e) {
		
			return $e->getMessage();
			
		}
    }

    public function getAdminId($user_id){

        return Admin::where('user_id','=',$user_id)->pluck('id');
    }

    public function verifyAdminId($id){

        return Admin::select('id','user_id')->where('id','=',$id)->first();

    }
    
    public function canDelete() {
	    $admins = Admin::all();
	    
	    return $admins->count() > config('futureed.admin_delete_threshold');
	}

}