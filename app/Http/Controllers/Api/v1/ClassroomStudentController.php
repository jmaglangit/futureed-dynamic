<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use Illuminate\Http\Request;

class ClassroomStudentController extends ApiController {

    /**
     * @var classrom protected
     */
    protected $classroom;

    /**
     * @param ClassroomRepositoryInterface $classroomRepositoryInterface
     */
    public function __construct(ClassroomRepositoryInterface $classroomRepositoryInterface){

        $this->classroom = $classroomRepositoryInterface;
    }

	/**
	 * Display list of students on the class.
	 *
	 * @return Response
	 */
	public function index()
	{




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
