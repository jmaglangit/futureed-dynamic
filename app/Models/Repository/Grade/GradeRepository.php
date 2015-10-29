<?php namespace FutureEd\Models\Repository\Grade;


use FutureEd\Models\Core\CountryGrade;
use FutureEd\Models\Core\Grade;
use Illuminate\Support\Facades\DB;

class GradeRepository implements GradeRepositoryInterface{


	/**
     * Get list of grades.
     * @param array $criteria
     * @param int $limit
     * @param int $offset
     * @return array
     */
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

        $grade = $grade->with('country')->orderBy('id', 'asc');

        return ['total' => $count, 'records' => $grade->get()->toArray()];




    }

	/**
     * Get Grade by code.
     * @param $code
     * @return mixed
     */
    public function getGrade($code){


        return Grade::where('code',$code)->with('countryGrade')->first();

    }

	/**
     * Add new Grade.
     * @param $data
     * @return string|static
     */
    public function addGrade($data){

		try {
		
			$grade = Grade::create($data);
			
		} catch(Exception $e) {
		
			return $e->getMessage();
			
		}
		
		return $grade;
	
    }

	/**
     * Update Grade record.
     * @param $id
     * @param $data
     * @return \Illuminate\Support\Collection|null|string|static
     */
    public function updateGrade($id,$data){

    	try {

    		$grade = Grade::find($id);
    		$grade->update($data);

    	} catch (Exception $e) {

    		return $e->getMessage();
    		
    	}

    	return $grade;


    }


	/**
     * Delete Grade
     * @param $id
     * @return bool|null|string
     */
    public function deleteGrade($id){

    	try {

			$grade = Grade::find($id);

			return !is_null($grade) ? $grade->delete() : false;

		} catch(Exception $e) {

			return $e->getMessage();

		}
    }



	/**
     * get grade record by id
     * @param $id
     * @return mixed
     */
    public function getGradeById($id){

        return Grade::where('id',$id)->first();

    }

	/**
     * return student if this record is related to student
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getStudentByCode($id){

        $grade_class = new Grade();

        $grade_class = $grade_class->with('students')->where('id',"=",$id);

        return $grade_class->first();

    }

	/**
     * Check country of Grades.
     * @param $country_id
     * @return mixed
     */
    public function checkCountry($country_id){

        return Grade::countryid($country_id)->get()->toArray();
    }

	/**
     * Get countries of Grades.
     * @return mixed
     */
    public function getGradeCountries(){

        return Grade::select('country_id')->groupByCountry()->get();
    }

    /**
     * Get Grades list by countries.
     * @param $country_id
     */
    public function getGradesByCountries($country_id){
        /*
        select * from country_grades cg
        left join country_grades cg2 on cg2.age_group_id=cg.age_group_id
        where cg2.country_id=702
        group by cg2.age_group_id
        ;
        */

        $country_id  = (empty($this->checkCountry($country_id))) ? config('futureed.default_country') : $country_id;

        $grade_list = CountryGrade::select(

            DB::raw('country_grades.id as id'),
            DB::raw('g.country_id'),
            DB::raw('g.code'),
            DB::raw('g.name'),
            DB::raw('g.description'),
            DB::raw('g.status')
        )->leftJoin('country_grades as cg2','cg2.age_group_id','=','country_grades.age_group_id')
            ->leftJoin('grades as g','g.id','=','cg2.grade_id')
            ->where('cg2.country_id',$country_id)
            ->groupBy('cg2.age_group_id')
            ->get();


        return $grade_list;




    }




}