<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

use FutureEd\Services\ErrorServices as Errors;

use FutureEd\Http\Requests\Api\GradeCustomRequest;

use FutureEd\Models\Repository\Grade\GradeRepositoryInterface as Grade;

use Illuminate\Support\Facades\Input;

class GradeCustomController extends ApiController {

    protected $grade;

    public function __construct(Grade $grade){

        $this->grade = $grade;

    }


    public function update($id,GradeCustomRequest $request){

        $data = $request->all();
        $grade_data = $this->grade->getGradeById($id);

        if(empty($grade_data)){

            return $this->respondErrorMessage(2120);

        }

        $grade = $this->grade->updateGrade($id,$data);

        return $this->respondWithData(['id' => $grade->id]);

    }






}