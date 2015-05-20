<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminController extends ApiController {

    protected $admin;

    /**
     * Admin constructor
     *
     * @return void
     */
    public function __construct(AdminRepositoryInterface $admin){

        $this->admin = $admin;
    }

	/**
	 * Display a list of Admin users.
	 *
	 * @return Response
	 */
	public function index()
	{
		//get header token

        $limit = Input::get('limit');

        //get the parameters and get outputs based on the parameters.
        if(Input::get('email')){

        }

        if(Input::get('username')){

        }

        if(Input::get('limit')){
            return $this->respondWithData($this->admin->getAdmins($limit));
        }

        return $this->respondWithData($this->admin->getAdmins());




	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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

        return $this->admin->getAdmin($id);
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
