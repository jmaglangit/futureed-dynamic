<?php namespace FutureEd\Models\Repository\Grade;


use FutureEd\Models\Core\Grade;

class GradeRepository implements GradeRepositoryInterface{


    public function getGrades(){

      return Grade:: all();

    }

    public function getGrade($code){


        return Grade::where('code',$code)->first();

    }

    public function addGrade($data){

    	$data['created_by'] = 1;
    	$data['updated_by'] = 1;

		try {
		
			$grade = Grade::create($data);
			
		} catch(Exception $e) {
		
			return $e->getMessage();
			
		}
		
		return $grade;
	
    }

    public function updateGrade($id,$data){

    	$data['created_by'] = 1;
    	$data['updated_by'] = 1;

    	try {

    		$grade = Grade::find($id);
    		$grade->update($data);

    	} catch (Exception $e) {

    		return $e->getMessage();
    		
    	}

    	return $grade;


    }


    public function deleteGrade($id){

    	try {

			$grade = Grade::find($id);

			return !is_null($grade) ? $grade->delete() : false;

		} catch(Exception $e) {

			return $e->getMessage();

		}

		return $grade;
    }

    //get grade record by id

    public function getGradeById($id){

        return Grade::where('id',$id)->first();

    }

    //return student if this record is related to student
    public function getStudentByCode($id){

        $grade_class = new Grade();

        $grade_class = $grade_class->with('students')->where('id',"=",$id);

        return $grade_class->first();

    }




}