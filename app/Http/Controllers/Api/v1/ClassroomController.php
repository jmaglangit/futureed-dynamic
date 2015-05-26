<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ClassroomController extends ApiController {

    protected $classroom;

    public function __construct(ClassroomRepositoryInterface $classroomRepositoryInterface){

        $this->classroom = $classroomRepositoryInterface;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $criteria = [];
        $limit = (Input::get('limit')) ? Input::get('limit') : 3;

        //get class name
        if(Input::get('name')){

            $criteria['email'] = Input::get('name');
        }

        $limit = (Input::get('limit')) ? Input::get('limit') : 0;

        $offset = (Input::get('offset')) ? Input::get('offset') : 0;



        return $this->respondWithData($this->classroom->getClassrooms($criteria,$limit,$offset));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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
