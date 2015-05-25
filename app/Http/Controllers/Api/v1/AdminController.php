<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Admin\AdminRepositoryInterface as Admin;
use FutureEd\Models\Repository\User\UserRepositoryInterface as User;
use Illuminate\Http\Request;
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
		$data = $request->all();
	
		$data['user_type'] = config('futureed.admin');
	
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
		//

        return $this->respondWithData($this->admin->getAdmin($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
