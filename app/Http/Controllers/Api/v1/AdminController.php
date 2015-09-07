<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

use FutureEd\Models\Repository\Admin\AdminRepositoryInterface as Admin;
use FutureEd\Models\Repository\User\UserRepositoryInterface as User;

use Illuminate\Support\Facades\Input;

use FutureEd\Http\Requests\Api\AdminRequest;

class AdminController extends ApiController {

    protected $admin;
    protected $user;

    /**
     * Admin constructor
     *
     * @return void
     */
    public function __construct(Admin $admin, User $user){

        $this->admin = $admin;
        $this->user = $user;
    }

	/**
	 * Display a list of Admin users.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = array();
		$limit = 0;
		$offset = 0;

        //get the parameters and get outputs based on the parameters.
        if(Input::get('email')){
			$criteria['email'] = Input::get('email');
        }

        if(Input::get('username')){
			$criteria['username'] = Input::get('username');
        }
        
        if(Input::get('role')){
			$criteria['role'] = Input::get('role');
        }

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}
		
		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		$admins = $this->admin->getAdmins($criteria, $limit, $offset);

		return $this->respondWithData($admins);

        /*
if(Input::get('limit')){
            return $this->respondWithData($this->admin->getAdmins($limit));
        }

        return $this->respondWithData($this->admin->getAdmins());
*/

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AdminRequest $request)
	{
		$data = $request->only(['username', 'password', 'email', 'admin_role', 'status', 'first_name', 'last_name']);
	
		$data['user_type'] = config('futureed.admin');

        $data['is_account_activated'] = config('futureed.activated');

		$user = $this->user->addUser($data);
		
		if($user) {
			$user_id = $this->user->checkEmail($data['email'], $data['user_type']);
			
			$data['user_id'] = $user_id;
			
			$admin = $this->admin->addAdmin($data);	
			
			return $this->respondWithData(['id' => $admin->id]);
		} else {
			return $this->respondWithData(['id' => NULL]);
		}
		
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if(Input::get('role')){
			$role = Input::get('role');
		}else {
			$role = config('futureed.admin_role_admin');
		}

        return $this->respondWithData($this->admin->getAdmin($id,$role));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AdminRequest $request)
	{
		#TODO: If admin role is Admin, it cannot edit Super Admin account. If admin role is Super Admin, then it can edit Admin and Super Admin account
	
		$data = $request->only(['username', 'password', 'admin_role', 'status', 'first_name', 'last_name']);
			
		$admin = $this->admin->updateAdmin($id, $data);
		
		if($admin) {
			$user = $this->user->updateUser($admin->user_id, $data);
			
			return $this->respondWithData(['id' => $admin->id]);
		} else {
			return $this->respondWithData(['id' => NULL]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		//If Admin deletes Super Admin respond error.
		if($this->admin->getAdminRole($id) == config('admin_role_super_admin')
			&& $this->admin->getAdminRole(session('current_user')) == config('admin')){

			return $this->respondErrorMessage(2601);
		}

		if($this->admin->canDelete() && $id <> session('current_user')) {
			$admin = $this->admin->deleteAdmin($id);
			
			if($admin) {
			
				$user = $this->user->deleteUser($admin->user_id);
				
				return $this->respondWithData(TRUE);
				
			} else {
				
				return $this->respondWithData(FALSE);
				
			}
			
		} else {
			return $this->respondErrorMessage(2601);
		}
	}

}
