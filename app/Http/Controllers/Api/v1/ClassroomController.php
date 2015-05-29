<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Core\Classroom;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use FutureEd\Http\Requests\Api\ClassroomRequest;

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

        //get class name
        if(Input::get('name')){

            $criteria['name'] = Input::get('name');
        }

        //get class grade
        if(Input::get('grade_id')){

            $criteria['grade_id'] = Input::get('grade_id');
        }


        $limit = (Input::get('limit')) ? Input::get('limit') : 3;

        $offset = (Input::get('offset')) ? Input::get('offset') : 0;


        return $this->respondWithData($this->classroom->getClassrooms($criteria,$limit,$offset));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ClassroomRequest $request)
	{
        $classroom = $request->only([
            'order_no',
            'name',
            'grade_id',
            'client_id',
            'seats_taken',
            'seats_total',
            'status'
        ]);

        $classroom = $this->classroom->addClassroom($classroom);

        return $this->respondWithData($classroom);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData($this->classroom->getClassroom($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, ClassroomRequest $request)
	{
        //can only update the name
        $input['name'] = $request->get('name');


        return $this->classroom->updateClassroom($id,$input);
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
