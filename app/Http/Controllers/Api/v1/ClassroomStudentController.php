<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\ClassStudents\ClassStudentsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ClassroomStudentController extends ApiController {

    /**
     * @var classrom protected
     */
    protected $class_students;


    /**
     * @param ClassStudentsRepositoryInterface $classStudentsRepositoryInterface
     */
    public function __construct(ClassStudentsRepositoryInterface $classStudentsRepositoryInterface){

        $this->class_students = $classStudentsRepositoryInterface;
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

        $category = [];

        if(Input::get('name')){

            $category['name'] = Input::get('name');
        }

        if(Input::get('email')){

            $category['email'] = Input::get('email');
        }

        if(Input::get('offset')){

            $category['offset'] = Input::get('offset');
        }

        if(Input::get('limit')){

            $category['limit'] = Input::get('limit');
        }

        $offset = (Input::get('offset')) ? Input::get('offset') : 0;

        $limit = (Input::get('limit')) ? Input::get('limit') : 0 ;

		return $this->respondWithData(
            $this->class_students->getClassroomStudents($id,$category,$offset,$limit)
        );
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
