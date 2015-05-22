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

        return $this->respondWithData($this->grade->getGrades());
        
    }

    public function store(GradeRequest $request){

    	$data = $request->all();

    	$grade = $this->grade->addGrade($data);

    	return $this->respondWithData(['id' => $grade->id]);

    }

    public function update($id,GradeRequest $request){

    	$data = $request->except(array('code'));

    	$grade = $this->grade->updateGrade($id,$data);

    	return $this->respondWithData(['id' => $grade->id]);

    }


    public function destroy($id){

        //check if this record is related to student before deleting
        $relation = $this->grade->getStudentByCode($id)->toArray();


       if($relation['students']) {

           return $this->respondErrorMessage(2119);
       }

        return $this->respondWithData($this->grade->deleteGrade($id));
    }



}
