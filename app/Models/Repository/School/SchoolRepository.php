<?php

namespace FutureEd\Models\Repository\School;

use FutureEd\Models\Core\School;
use FutureEd\Models\Core\StudentModuleAnswer;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use FutureEd\Services\CodeGeneratorServices;
use Carbon\Carbon;


class SchoolRepository implements SchoolRepositoryInterface{

	use LoggerTrait;

	/**
	 * @param CodeGeneratorServices $code
	 */
	public function __construct(CodeGeneratorServices $code){
		$this->code = $code;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function getSchools(){

		DB::beginTransaction();

		try {

			$response = School::all();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
    }

	/**
	 * @param $school_code
	 * @return mixed
	 */
	public function getSchoolName($school_code){

		DB::beginTransaction();

		try {

			$response = School::where('code', '=', $school_code)->pluck('name');

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $school
	 * @return int|string
	 */
	public function addSchool($school){

		DB::beginTransaction();


		try{
			$code = $code = Carbon::now()->timestamp;

			School::insert([
				'code' => $code,
				'name' => $school['school_name'],
				'street_address' => $school['school_address'],
				'city' => $school['school_city'],
				'state' => $school['school_state'],
				'country' => isset($school['school_country']) ? $school['school_country'] : 0,
				'country_id' => isset($school['school_country_id']) ? $school['school_country_id'] : 0,
				'zip' => $school['school_zip'],
				'contact_name' => $school['contact_name'],
				'contact_number' => $school['contact_number'],
				'created_by' => 1,
				'updated_by' => 1,
			]);

			$response = $code;

		}catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $name
	 * @return mixed
	 */
	public function getSchoolId($name){

		DB::beginTransaction();

		try {

			$response = School::where('name', '=', $name)->pluck('id');

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $input
	 * @return mixed
	 */
	public function checkSchoolName($input){

		DB::beginTransaction();

		try {

			$response = School::where('name', '=', $input['school_name'])
				->where('street_address', '=', $input['school_address'])
				->where('state', '=', $input['school_state'])->pluck('id');

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function getSchoolDetails($id){

		DB::beginTransaction();

		try {

			$response = School::where('code', '=', $id)->first();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $input
	 * @return mixed
	 */
	public function checkSchoolNameExist($input){

		DB::beginTransaction();

		try {

			$response = School::where('name', '=', $input['school_name'])
				->where('street_address', '=', $input['school_street_address'])
				->where('state', '=', $input['school_state'])->pluck('code');

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $input
	 * @return string
	 */
	public function updateSchoolDetails($input){

		DB::beginTransaction();

		try {
			foreach ($input as $key => $value) {

				if ($value != null) {

					$update[substr($key, 7)] = $value;

				} else {

					$update[substr($key, 7)] = null;

				}
			}

			$response = School::where('code', $input['school_code'])->update($update);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $school_name
	 * @return mixed
	 */
	public function getSchoolCode($school_name){

		DB::beginTransaction();

		try {

			$response = School::where('name', '=', $school_name)->pluck('code');

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $school_name
	 * @return mixed
	 */
	public function searchSchool($school_name){

		DB::beginTransaction();

		try {

			$response = School::select('name', 'code', 'city', 'state', 'street_address')
				->where('name', 'Like', $school_name . '%')->get()->toArray();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get school by school code.
	 * @param $school_code
	 * @return mixed
	 */
	public function getSchoolByCode($school_code){

		DB::beginTransaction();

		try {

			$response = School::whereCode($school_code)->get();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get School Area rankings.
	 * @param $school_code
	 * @return string
	 * @internal param $school_id
	 */
	public function getSchoolAreaRanking($school_code) {
		//select
		//-- s.id as s_id,s.code as s_code
		//-- ,c.id as c_id, c.user_id as c_user_id
		//-- ,cr.id as cr_id,cr.name as cr_name
		//-- ,sb.id as sb_id,sb.name as sb_name
		//-- ,sa.id as sa_id,sa.name as sa_name
		//-- ,m.id as m_id, m.name as m_name
		//-- ,sm.id as sm_id,sm.class_id as sm_class_id, sm.subject_id as sm_subject_id,sm.student_id as sm_student_id, sm.module_status as sm_module_status, sm.progress as sm_progress
		//-- ,
		//sa.name as subject_name, avg(sm.progress) as percent_progress
		//from schools s
		//left join clients c on s.code=c.school_code and c.client_role='Teacher'
		//left join classrooms cr on cr.client_id=c.id
		//left join orders o on o.order_no=cr.order_no
		//left join subjects sb on sb.id=cr.subject_id
		//left join subject_areas sa on sa.subject_id=sb.id
		//left join modules m on m.subject_area_id=sa.id
		//left join student_modules sm on sm.module_id=m.id and sm.subject_id=sb.id and sm.class_id=cr.id and sm.module_status <> 'Failed' and sm.deleted_at is NULL
		//where
		//s.code = 1441379529
		//and date(o.date_start) <= now() and date(o.date_end) >= now()
		//and cr.id is not null
		//and sm.module_id is not null
		//and sm.progress > 0
		//group by sa.name
		//order by percent_progress desc
		//;

		DB::beginTransaction();
		try {

			$response = School::select(
				DB::raw('sa.name as subject_name'),
				DB::raw('round(avg(sm.progress)) as percent_progress'),
				DB::raw('g.name as grade_name')
			)->leftJoin('clients as c', function ($left_join) {
				$left_join->on('schools.code', '=', 'c.school_code')
					->on('c.client_role', '=', DB::raw("'" . config('futureed.teacher') . "'"));
			})->leftJoin('classrooms as cr', 'cr.client_id', '=', 'c.id')
				->leftJoin('orders as o', 'o.order_no', '=', 'cr.order_no')
				->leftJoin('subjects as sb', 'sb.id', '=', 'cr.subject_id')
				->leftJoin('subject_areas as sa', 'sa.subject_id', '=', 'sb.id')
				->leftJoin('modules as m', 'm.subject_area_id', '=', 'sa.id')
				->leftJoin('grades as g','m.grade_id','=','g.id')
				->leftJoin('student_modules as sm', function ($left_join) {
					$left_join->on('sm.module_id', '=', 'm.id')
						->on('sm.subject_id', '=', 'sb.id')
						->on('sm.class_id', '=', 'cr.id')
						->on('sm.module_status', '<>', DB::raw("'" . config('futureed.module_status_failed') . "'"))
						->whereNULL('sm.deleted_at');
				})->where('schools.code', '=', $school_code)
				->where(DB::raw('o.date_start'), '<=', DB::raw('now()'))
				->where(DB::raw('o.date_end'), '>=', DB::raw('now()'))
				->whereNotNull('cr.id')
				->whereNotNull('sm.module_id')
				->where('sm.progress', '>', 0)
				->groupBy('sa.name')
				->orderBy('percent_progress', 'desc')
				->get();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return $e->getMessage();
		}

		DB::commit();

		return $response;
	}


	/**
	 * Get School Class Rankings.
	 * @param $school_code
	 * @return string
	 */
	public function getSchoolClassRanking($school_code){
			//select
			///* s.id as s_id,s.code as s_code
			//,c.id as c_id, c.user_id as c_user_id
			//,cr.id as cr_id,cr.name as cr_name
			//,sb.id as sb_id,sb.name as sb_name
			//,sa.id as sa_id,sa.name as sa_name
			//,m.id as m_id, m.name as m_name
			//,sm.id as sm_id,sm.class_id as sm_class_id, sm.subject_id as sm_subject_id,sm.student_id as sm_student_id, sm.module_status as sm_module_status, sm.progress as sm_progress
			//,  */
			//-- sa.name as subject_name, avg(sm.progress) as percent_progress
			//c.id, c.first_name, c.last_name, cr.name, avg(sm.progress) as percent_progress
			//from schools s
			//left join clients c on s.code=c.school_code and c.client_role='Teacher'
			//left join classrooms cr on cr.client_id=c.id
			//left join orders o on o.order_no=cr.order_no
			//left join subjects sb on sb.id=cr.subject_id
			//left join subject_areas sa on sa.subject_id=sb.id
			//left join modules m on m.subject_area_id=sa.id
			//left join student_modules sm on sm.module_id=m.id and sm.subject_id=sb.id and sm.class_id=cr.id and sm.module_status <> 'Failed' and sm.deleted_at is NULL
			//where
			//s.code = 1441379529
			//and date(o.date_start) <= now() and date(o.date_end) >= now()
			//and cr.id is not null
			//and sm.module_id is not null
			//and sm.progress > 0
			//group by c.id
			//order by percent_progress desc
			//;

		DB::beginTransaction();
		try {

			$response = School::select(
				DB::raw('c.id, c.first_name, c.last_name, cr.name as class_name, round(avg(sm.progress)) as percent_progress')
			)->leftJoin('clients as c', function ($left_join) {
				$left_join->on('schools.code', '=', 'c.school_code')
					->on('c.client_role', '=', DB::raw("'" . config('futureed.teacher') . "'"));
			})->leftJoin('classrooms as cr', 'cr.client_id', '=', 'c.id')
				->leftJoin('orders as o', 'o.order_no', '=', 'cr.order_no')
				->leftJoin('subjects as sb', 'sb.id', '=', 'cr.subject_id')
				->leftJoin('subject_areas as sa', 'sa.subject_id', '=', 'sb.id')
				->leftJoin('modules as m', 'm.subject_area_id', '=', 'sa.id')
				->leftJoin('student_modules as sm', function ($left_join) {
					$left_join->on('sm.module_id', '=', 'm.id')
						->on('sm.subject_id', '=', 'sb.id')
						->on('sm.class_id', '=', 'cr.id')
						->on('sm.module_status', '<>', DB::raw("'" . config('futureed.module_status_failed') . "'"))
						->whereNULL('sm.deleted_at');
				})->where('schools.code', '=', $school_code)
				->where(DB::raw('o.date_start'), '<=', DB::raw('now()'))
				->where(DB::raw('o.date_end'), '>=', DB::raw('now()'))
				->whereNotNull('cr.id')
				->whereNotNull('sm.module_id')
				->where('sm.progress', '>', 0)
				->groupBy('c.id')
				->orderBy('percent_progress', 'desc')
				->get();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return $e->getMessage();
		}

		DB::commit();

		return $response;
	}


	/**
	 * Get School Student Rankings.
	 * @param $school_code
	 * @return string
	 */
	public function getSchoolStudentRanking($school_code){
			//select
			///* s.id as s_id,s.code as s_code
			//,c.id as c_id, c.user_id as c_user_id
			//,cr.id as cr_id,cr.name as cr_name
			//,sb.id as sb_id,sb.name as sb_name
			//,sa.id as sa_id,sa.name as sa_name
			//,m.id as m_id, m.name as m_name
			//,sm.id as sm_id,sm.class_id as sm_class_id, sm.subject_id as sm_subject_id,sm.student_id as sm_student_id, sm.module_status as sm_module_status, sm.progress as sm_progress */
			//stud.id, stud.first_name, stud.last_name, avg(sm.progress) as percent_progress
			//from schools s
			//left join clients c on s.code=c.school_code and c.client_role='Teacher'
			//left join classrooms cr on cr.client_id=c.id
			//left join orders o on o.order_no=cr.order_no
			//left join subjects sb on sb.id=cr.subject_id
			//left join subject_areas sa on sa.subject_id=sb.id
			//left join modules m on m.subject_area_id=sa.id
			//left join student_modules sm on sm.module_id=m.id and sm.subject_id=sb.id and sm.class_id=cr.id and sm.module_status <> 'Failed' and sm.deleted_at is NULL
			//left join students stud on stud.id=sm.student_id
			//where
			//s.code = 1441379529
			//and date(o.date_start) <= now() and date(o.date_end) >= now()
			//and cr.id is not null
			//and sm.module_id is not null
			//and sm.progress > 0
			//group by stud.id
			//order by percent_progress desc
			//;
		DB::beginTransaction();
		try {

			$response = School::select(
				DB::raw('stud.id, stud.first_name, stud.last_name, avg(sm.progress) as percent_progress')
			)->leftJoin('clients as c', function ($left_join) {
				$left_join->on('schools.code', '=', 'c.school_code')
					->on('c.client_role', '=', DB::raw("'" . config('futureed.teacher') . "'"));
			})->leftJoin('classrooms as cr', 'cr.client_id', '=', 'c.id')
				->leftJoin('orders as o', 'o.order_no', '=', 'cr.order_no')
				->leftJoin('subjects as sb', 'sb.id', '=', 'cr.subject_id')
				->leftJoin('subject_areas as sa', 'sa.subject_id', '=', 'sb.id')
				->leftJoin('modules as m', 'm.subject_area_id', '=', 'sa.id')
				->leftJoin('student_modules as sm', function ($left_join) {
					$left_join->on('sm.module_id', '=', 'm.id')
						->on('sm.subject_id', '=', 'sb.id')
						->on('sm.class_id', '=', 'cr.id')
						->on('sm.module_status', '<>', DB::raw("'" . config('futureed.module_status_failed') . "'"))
						->whereNULL('sm.deleted_at');
				})->leftJoin('students as stud','stud.id','=','sm.student_id')
				->where('schools.code', '=', $school_code)
				->where(DB::raw('o.date_start'), '<=', DB::raw('now()'))
				->where(DB::raw('o.date_end'), '>=', DB::raw('now()'))
				->whereNotNull('cr.id')
				->whereNotNull('sm.module_id')
				->where('sm.progress', '>', 0)
				->groupBy('stud.id')
				->orderBy('percent_progress', 'desc')
				->get();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return $e->getMessage();
		}

		DB::commit();

		return $response;


	}


	/**
	 * Get School Students Scores.
	 * @param $school_code
	 * @return string
	 */
	public function getSchoolStudentScores($school_code){
		//select
		//sma.id,stud.id as student_id, stud.first_name, stud.last_name
		//,count(case when sma.answer_status = 'Correct' then 1 else null end) as Correct
		//,count(case when sma.answer_status = 'Wrong' then 1 else null end) as Wrong
		//,cl.first_name,cl.last_name
		//
		//from student_module_answers sma
		//left join student_modules sm on sma.student_module_id=sm.id
		//left join students stud on stud.id=sm.student_id
		//left join classrooms c on c.id=sm.class_id
		//left join orders o on o.order_no=c.order_no
		//left join clients cl on cl.id=c.client_id
		//left join schools sch on sch.code = cl.school_code
		//where
		//o.date_start <= now() and o.date_end >= now()
		//and sch.code = 1441379529
		//group by student_id
		//;

		DB::beginTransaction();
		try{

			$response = StudentModuleAnswer::select(
					DB::raw('student_module_answers.id as student_module_answer')
					,DB::raw('stud.id as student_id')
					,DB::raw('stud.first_name as stud_first_name')
					,DB::raw('stud.last_name as stud_last_name')
					,DB::raw("count(case when student_module_answers.answer_status = 'Correct' then 1 else null end) as Correct")
					,DB::raw("count(case when student_module_answers.answer_status = 'Wrong' then 1 else null end) as Wrong")
					,DB::raw("cl.first_name as client_first_name")
					,DB::raw("cl.last_name as client_last_name")
			)->leftJoin('student_modules as sm','sm.id','=','student_module_answers.student_module_id')
					->leftJoin('students as stud','stud.id','=','sm.student_id')
					->leftJoin('classrooms as c','c.id','=','sm.class_id')
					->leftJoin('orders as o','o.order_no','=','c.order_no')
					->leftJoin('clients as cl','cl.id','=','c.client_id')
					->leftJoin('schools as sch','sch.code','=','cl.school_code')
					->where('o.date_start','<=', Carbon::now())
					->where('o.date_end','>=',Carbon::now())
					->where('sch.code','=', $school_code)
					->groupBy('student_id')
					->get();
			;

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return $e->getMessage();
		}

		DB::commit();

		return $response;

	}

    /**
     * Returns a school with all it's teachers, classrooms at a particular level
     * @param $school_code
     * @param $grade_level
     * @return string
     */
    public function getTeacherSubjectProgress($school_code, $grade_level) {

        DB::beginTransaction();

        try{

            $response = School::select(['id', 'code', 'name', 'street_address', 'country_id'])
                ->whereCode($school_code)
                ->with(['teachers.classroom' => function($query) use ($grade_level){

                    $query->select(
                        ['id', 'name', 'grade_id', 'client_id', 'subject_id', 'seats_taken'])
                        ->where('grade_id', $grade_level)
                        ->with(['studentModule' => function($query) {

                            $query->select(
                                ['id', 'student_id', 'subject_id', 'progress',
                                    'question_counter', 'correct_counter']);

                        }]);

                }])->first();

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return $e->getMessage();
        }

        DB::commit();

        return $response;

    }

}