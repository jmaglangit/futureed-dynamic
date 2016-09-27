<?php namespace FutureEd\Models\Repository\Grade;


use FutureEd\Models\Core\CountryGrade;
use FutureEd\Models\Core\Grade;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class GradeRepository implements GradeRepositoryInterface{
	use LoggerTrait;

	/**
	 * Get list of grades.
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getGrades($criteria = [],$limit = 0, $offset = 0){
		DB::beginTransaction();

		try{
			$grade = new Grade();


			$count = 0;

			//if current user not admin
			if(empty(session('admin'))){
				//select only enabled

				$grade = $grade->status(config('futureed.enabled'));
			}

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

			$response = ['total' => $count, 'records' => $grade->get()->toArray()];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Grade by code.
	 * @param $code
	 * @return mixed
	 */
	public function getGrade($code){
		DB::beginTransaction();

		try{
			$grade = Grade::where('code',$code)->with('countryGrade');

			if(empty(session('admin'))){
				//select only enabled
				$grade = $grade->status(config('futureed.enabled'));
			}

			$response = $grade->first();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add new Grade.
	 * @param $data
	 * @return string|static
	 */
	public function addGrade($data){
		DB::beginTransaction();

		try {
		
			$response = Grade::create($data);
			
		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update Grade record.
	 * @param $id
	 * @param $data
	 * @return \Illuminate\Support\Collection|null|string|static
	 */
	public function updateGrade($id,$data){
		DB::beginTransaction();

		try {
			$grade = Grade::find($id);
			$grade->update($data);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $grade;
	}


	/**
	 * Delete Grade
	 * @param $id
	 * @return bool|null|string
	 */
	public function deleteGrade($id){
		DB::beginTransaction();

		try {
			$grade = Grade::find($id);

			$response = !is_null($grade) ? $grade->delete() : false;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}



	/**
	 * get grade record by id
	 * @param $id
	 * @return mixed
	 */
	public function getGradeById($id){
		DB::beginTransaction();

		try{
			$grade = Grade::where('id',$id);

			if(empty(session('admin'))){
				//select only enabled
				$grade = $grade->status(config('futureed.enabled'));
			}

			$response = $grade->first();


		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * return student if this record is related to student
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Model|null|static
	 */
	public function getStudentByCode($id){
		DB::beginTransaction();

		try{
			$grade = new Grade();

			if(empty(session('admin'))){
				//select only enabled
				$grade = $grade->status(config('futureed.enabled'));
			}

			$grade_class = $grade->with('students')->where('id',"=",$id);
			$response = $grade_class->first();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Check country of Grades.
	 * @param $country_id
	 * @return mixed
	 */
	public function checkCountry($country_id){
		DB::beginTransaction();

		try{
			$grade = Grade::countryid($country_id);

			if(empty(session('admin'))){
				//select only enabled
				$grade = $grade->status(config('futureed.enabled'));
			}

			$response = $grade->get()->toArray();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get countries of Grades.
	 * @return mixed
	 */
	public function getGradeCountries(){
		DB::beginTransaction();

		try{
			$grade = Grade::select('country_id')->groupByCountry();

			if(empty(session('admin'))){
				//select only enabled
				$grade = $grade->status(config('futureed.enabled'));
			}

			$response = $grade->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Grades list by countries.
	 * @param $country_id
	 * @return bool
	 */
	public function getGradesByCountries($country_id){
		/*
		select * from country_grades cg
		left join country_grades cg2 on cg2.age_group_id=cg.age_group_id
		where cg2.country_id=702
		group by cg2.age_group_id
		;
		*/

		DB::beginTransaction();

		try{
			$country_id  = (empty($this->checkCountry($country_id))) ? config('futureed.default_country') : $country_id;

			$grade_list = CountryGrade::select(
				DB::raw('country_grades.id as id'),
				DB::raw('g.country_id'),
				DB::raw('g.code'),
				DB::raw('g.name'),
				DB::raw('g.description'),
				DB::raw('g.status')
				)->leftJoin('country_grades as cg2','cg2.age_group_id','=','country_grades.age_group_id')
				->leftJoin('grades as g',function($join){
					if(empty(session('admin'))){
						$join->on('g.id','=','cg2.grade_id')->where('g.status','=',config('futureed.enabled'));
					} else {
						$join->on('g.id','=','cg2.grade_id');
					}
				})
				->where('cg2.country_id',$country_id)
				->whereNotNull('g.status')
				->groupBy('cg2.age_group_id')
				->get();

			$response = $grade_list;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}