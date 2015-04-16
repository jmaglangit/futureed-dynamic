<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class StudentsController extends ApiController {
    

    public function getStudentParent(){
        $input = Input::only('parent_id');

        $students = $this->student->getStudentByParent($input['parent_id']);
        return $this->respondWithData([
            $students
        ]);

    }
    
    
    public function getStudentDetails(){
        $input = Input::only('user_id');
        
        $students = $this->student->getStudentInfo($input['user_id']); 
        return $this->respondWithData([
            $students
        ]);
    }


}
