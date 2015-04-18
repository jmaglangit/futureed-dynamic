<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class StudentController extends ApiController {
    

    public function getStudentParent(){
        $input = Input::only('parent_id');

        $students = $this->student->getStudentByParent($input['parent_id']);
        return $this->respondWithData([
            $students
        ]);

    }
    
    
    public function getStudentDetails(){
        $input = Input::only('id');
        
        $students = $this->student->getStudentDetails($input['id']); 
        return $this->respondWithData([
            $students
        ]);
    }
    
    
    //edit student
    public function editStudent($id){
      $input = Input::only('first_name','last_name','gender','birth_date',
                            'email','username','school_code','grade_code',
                            'country','city','state');
      
      if(!$input['first_name'] || !$input['last_name'] || !$input['gender'] || 
         !$input['birth_date'] || !$input['email'] || !$input['username'] || 
         !$input['school_code'] || !$input['grade_code'] || !$input['country'] ||
         !$input['city'] || !$input['state']){
            
            return $this->setStatusCode(422)
                            ->respondWithError(['error_code'=>422,
                                             'message'=>'Parameter validation failed'
                                              ]);
      }else{
      
          $return = $this->student->validateStudentDetails($input);
          
          if($return['status']==200){
               $this->student->updateStudentDetails($id,$input);
               return $this->respondWithData(['id'=>$id]);
               
          }else{
            
               return $this->setStatusCode(202)
                           ->respondWithData(['error_code'=>202,
                                        'message'=>$return['data']]); 
            
          }
      }
      
      
    }


}
