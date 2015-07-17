<?php namespace FutureEd\Models\Repository\Grade;


use FutureEd\Models\Core\Grade;

class GradeRepository implements GradeRepositoryInterface{


    public function getGrades($criteria = [],$limit = 0, $offset = 0){

        $grade = new Grade();


        $count = 0;

        if(count($criteria) <= 0 && $limit == 0 && $offset == 0) {

            $count = $grade->count();

        } else {

            if(count($criteria) > 0) {
                if(isset($criteria['name'])) {

                    $grade = $grade->with('country')->name($criteria['name']);

                }

                if(isset($criteria['country_id']) && $criteria['country_id'] <> 'all'){

                    $grade = $grade->with('country')->countryid($criteria['country_id']);
                }

                if($criteria['country_id'] == 'all'){

                    $grade = $grade->with('country');

                }
            }

            $count = $grade->count();

            if($limit > 0 && $offset >= 0) {
                $grade = $grade->with('country')->offset($offset)->limit($limit);
            }

        }

        $grade = $grade->with('country')->orderBy('name', 'asc');

        return ['total' => $count, 'records' => $grade->get()->toArray()];




    }

    public function getGrade($code){


        return Grade::where('code',$code)->first();

    }

    public function addGrade($data){

		try {
		
			$grade = Grade::create($data);
			
		} catch(Exception $e) {
		
			return $e->getMessage();
			
		}
		
		return $grade;
	
    }

    public function updateGrade($id,$data){

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

    /**
     * Get countries of Grades
     *
     * @param $country_id
     */
    public function getCountry(){

        return Grade::select('country_id')->distinct()->with('country')->get();
    }

    public function checkCountry($country_id){

        return Grade::countryid($country_id)->get()->toArray();
    }




}