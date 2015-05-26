<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

use FutureEd\Services\ErrorServices as Errors;

use FutureEd\Http\Requests\Api\GradeRequest;

use FutureEd\Models\Repository\Grade\GradeRepositoryInterface as Grade;

use Illuminate\Support\Facades\Input;

class GradeController extends ApiController {

	protected $grade;

	public function __construct(Grade $grade){

		$this->grade = $grade;

	}


    //get list of grade levels
	public function index(){

        $criteria = array();
        $limit = 0;

        $criteria = array();
        $limit = 0;
        $offset = 0;

        if(Input::get('name')) {
            $criteria['name'] = Input::get('name');
        }


        if(Input::get('country_id')) {
            $criteria['coutnry_id'] = Input::get('country_id');
        }



        if(Input::get('limit')) {
            $limit = intval(Input::get('limit'));
        }

        if(Input::get('offset')) {
            $offset = intval(Input::get('offset'));
        }

        $grade = $this->grade->getGrades($criteria,$limit,$offset);


        return $this->respondWithData($grade);
        
    }

    public function show($id){

        $grade = $this->grade->getGradeById($id);

        if(empty($grade)){

            return $this->respondErrorMessage(2120);

        }

        return $this->respondWithData($grade);

    }

    public function store(GradeRequest $request){

    	$data = $request->all();

    	$grade = $this->grade->addGrade($data);

    	return $this->respondWithData(['id' => $grade->id]);

    }

    public function update($id,GradeRequest $request){

    	$data = $request->except(array('code'));
        $grade = $this->grade->getGradeById($id);

        if(empty($grade)){

            return $this->respondErrorMessage(2120);

        }


    	$grade = $this->grade->updateGrade($id,$data);

    	return $this->respondWithData([$grade]);

    }


    public function destroy($id){

        //check if this record is related to student before deleting
        $relation = $this->grade->getStudentByCode($id);

        if(empty($relation)){

            return $this->respondErrorMessage(2120);
        }

       if($relation['students']->toArray()) {

           return $this->respondErrorMessage(2119);
       }

        return $this->respondWithData($this->grade->deleteGrade($id));
    }



}
