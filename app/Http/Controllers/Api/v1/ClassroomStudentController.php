<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;


use FutureEd\Models\Core\ClassStudent;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
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
    public function __construct(ClassStudentRepositoryInterface $classStudentRepositoryInterface){

        $this->class_students = $classStudentRepositoryInterface;
    }


	/**
	 * student list under class
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

        $category = [];

        $category['class_id'] = $id;
        if(Input::get('name')){

            $category['name'] = Input::get('name');
        }

        if(Input::get('email')){

            $category['email'] = Input::get('email');
        }

		if(Input::get('class_id')){

			$category['class_id'] = Input::get('class_id');
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
            $this->class_students->getClassStudents($category,$offset,$limit)
        );
	}



}
