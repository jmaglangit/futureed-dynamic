<?php
namespace FutureEd\Models\Repository\ClassStudent;

use Carbon\Carbon;
use FutureEd\Models\Core\ClassStudent;
use FutureEd\Models\Core\Classroom;
use FutureEd\Models\Core\Subject;
use FutureEd\Models\Repository\Module\ModuleRepository as ModuleRepository;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use FutureEd\Models\Traits\LoggerTrait;

class ClassStudentRepository implements ClassStudentRepositoryInterface
{
	use LoggerTrait;

	protected $module;

	public function __construct(
		ModuleRepository $moduleRepository
	){
		$this->module = $moduleRepository;

	}
	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getClassStudents($criteria = [], $limit = 0, $offset = 0)
	{


		$class_student = new ClassStudent();
		$class_student = $class_student->isDateRemovedNull();
		$class_student = $class_student->with('student');

		if (isset($criteria['class_id'])) {

			$class_student = $class_student->classroom($criteria['class_id']);
		}

		if (isset($criteria['name'])) {

			$class_student = $class_student->name($criteria['name']);
		}

		if (isset($criteria['email'])) {

			$class_student = $class_student->email($criteria['email']);
		}

		if(isset($criteria['student_id'])){

			$class_student = $class_student->studentId($criteria['student_id']);
			$class_student = $class_student->active();
			$class_student = $class_student->with('classroom');
			$class_student = $class_student->subjectEnabled();
			$class_student = $class_student->paidOrder();

		}

		if ($limit > 0 && $offset >= 0) {

			$class_student = $class_student->offset($offset)->limit($limit);
		}

		$records = $class_student->get();
		$count = $class_student->get()->count();

		return [
			'total' => $count,
			'records' => $records
		];
	}

	public function getClassStudent($student_id)
	{

		return ClassStudent::where('student_id', $student_id)
			->active()
			->pluck('student_id');
	}

	public function addClassStudent($class_student)
	{
		try {
			return ClassStudent::create($class_student)->toArray();
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */

	public function updateClassStudent($id, $class_student)
	{
		try{

			return ClassStudent::find($id)
				->update($class_student);

		} catch (Exception $e) {

			throw new Exception($e->getMessage());
		}

	}

	public function deleteClassStudent($id)
	{

	}

	public function getClassroom($class_id)
	{
		$classroom = Classroom::find($class_id);
		return !is_null($classroom) ? $classroom->toArray() : null;
	}

	/**
	 * @param $student_id
	 * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
	 */
	public function getStudentCurrentClassroom($student_id)
	{
		return ClassStudent::with('classroom')
			->studentid($student_id)
			->active()
			->currentdate(Carbon::now())
			->first();
	}

	/**
	 * Get Active Class Student by student_id
	 * @param $student_id
	 */
	public function getActiveClassStudent($student_id)
	{
		return ClassStudent::with('classroom')
			->studentId($student_id)
			->get();
	}

	/**
	 * Set to Inactive Class.
	 * @param $id
	 */
	public function setClassStudentInactive($id)
	{
		try{
			return ClassStudent::id($id)
				->update([
					'subscription_status' => config('futureed.inactive')
				]);
		}catch (Exception $e){
			return $e->getMessage();
		}
	}

	/**
	 * Get Inactive Student Class has date today.
	 * @param $student_id
	 */
	public function getInactiveClassStudent($student_id)
	{
		return ClassStudent::with('classroom')
			->studentId($student_id)
			->currentDate(Carbon::now())
			->get();
	}

	/**
	 * Set Class student to Active.
	 * @param $id
	 */
	public function setClassStudentActive($id)
	{
		try {

			return ClassStudent::id($id)
				->update([
					'subscription_status' => config('futureed.active')
				]);
		} catch (Exception $e){

			return $e->getMessage();
		}
	}

	/**
	 * Check if student is Enrolled in a class.
	 * @param $student_id,$class_id
	 */
	public function isEnrolled($student_id,$class_id)
	{

		$class_student = new  ClassStudent();
		$class_student = $class_student->studentId($student_id)->classroom($class_id);

		return $class_student->first();

	}

	/**
	 * get the class student record by class_id.
	 * @param $student_id,$class_id
	 */
	public function getClassStudentByClassId($class_id)
	{

		$class_student = new  ClassStudent();
		$class_student = $class_student->where('class_id',$class_id);
		return $class_student->get();

	}

	/**
	 * get the class student record by id.
	 * @param $id
	 */
	public function getClassStudentById($id)
	{

		$class_student = new  ClassStudent();
		$class_student = $class_student->with('student','classroom')->find($id);
		return $class_student;

	}


	/**
	 * Get Current student class.
	 * @param $criteria
	 * @return mixed
	 */
	public function getCurrentClassStudent($criteria){

		try {

			$class_student = ClassStudent::studentId($criteria['student_id'])
				->isDateRemovedNull()
				->classroomId($criteria['class_id'])
				->with('studentClassroom');

			//Modules search student_id, class_id, module_name, grade_id, module_status
			$subject = $class_student->first();

			//Get subject_id
			$criteria['subject_id'] = $subject->studentClassroom->studentSubject->id;

			$student_modules = $this->module->getModulesByStudentProgress($criteria);

			if ($student_modules) {

				//merge module
				$subject->studentClassroom->studentSubject->student_modules = $student_modules;

				return $subject;

			} else {

				return null;
			}

		} catch (\Exception $e) {

			return null;
		}

	}

	/**
	 * Get Subject standing status.
	 * @param $student_id
	 * @return int
	 */
	public function getClassStudentStanding($student_id){

		DB::beginTransaction();
		try{

				 $subject = ClassStudent::select(
					 'class_students.student_id', 'subjects.name',
					 DB::raw('sum(IF (student_modules.points_earned, student_modules.points_earned, 0)) as points_earned'),
					 DB::raw("if(student_modules.module_status,student_modules.module_status,'Not Started') as module_status")
				 )->leftJoin('classrooms', 'class_students.class_id', '=', 'classrooms.id')
					 ->leftJoin('subjects', 'subjects.id', '=', 'classrooms.subject_id')
					 ->leftJoin('orders', 'orders.order_no', '=', 'classrooms.order_no')
					 ->leftJoin('modules', 'modules.subject_id', '=', 'subjects.id')
					 ->leftJoin('student_modules', function ($join) {
						 $join->on('student_modules.module_id', '=', 'modules.id')
							 ->on('class_students.student_id', '=', 'student_modules.student_id');
					 })
					 ->where('orders.payment_status', config('futureed.paid'))
					 ->where('orders.date_start', '<=', Carbon::now())
					 ->where('orders.date_end', '>=', Carbon::now())
					 ->where('class_students.student_id', $student_id)
					 ->groupBy('subjects.name')
					 ->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e);

			return 0;
		}

		DB::commit();

		return $subject;
	}

	/**
	 * Get student modules by student id and grade
	 * @param $student_id
	 * @param $subject_id
	 * @param $country_id
	 * @return string
	 */
	public function getStudentModulesProgressByGrade($student_id, $subject_id, $country_id){
//select
//m.grade_id ,count(*) as module_count, count(sm.id) as visited , count(smc.id) as completed, count(smo.id) as on_going
//from class_students cs
//left join classrooms c on c.id=cs.class_id
//left join orders o on o.order_no = c.order_no
//left join subjects s on s.id = c.subject_id
//left join modules m on m.subject_id = s.id
//left join country_grades cg on m.grade_id=cg.grade_id
//left join country_grades cg2 on cg2.age_group_id=cg.age_group_id and cg2.country_id = 702
//left join grades g on g.id=cg2.grade_id
//left join student_modules sm on sm.module_id=m.id and sm.student_id=3 and sm.module_status <> 'Failed'
// left join student_modules smc on smc.module_id=m.id and smc.student_id=3 and sm.module_status = 'Completed'
//left join student_modules smo on smo.module_id=m.id and smo.student_id=3 and sm.module_status = 'On Going'
//
//
//where date(o.date_start) <= now()  and date(o.date_end) >= now() and cs.student_id=3
//group by m.grade_id
//		;
		try {


			return ClassStudent::select(
				DB::raw('m.grade_id'),
				DB::raw('count(*) as module_count'),
				DB::raw('count(sm.id) as visited'),
				DB::raw('count(smc.id) as completed'),
				DB::raw(' count(smo.id) as on_going')
			)->leftJoin('classrooms as c', 'c.id', '=', 'class_students.class_id')
				->leftJoin('orders as o', 'o.order_no', '=', 'c.order_no')
				->leftJoin('subjects as s', 's.id', '=', 'c.subject_id')
				->leftJoin('modules as m', 'm.subject_id', '=', 's.id')
				->leftJoin('country_grades as cg', 'cg.grade_id', '=', 'm.grade_id')
				->leftJoin('country_grades as cg2', function ($left_join) use ($country_id) {
					$left_join->on('cg2.age_group_id', '=', 'cg.age_group_id')
						->on('cg2.country_id','=',
							DB::raw($country_id)
						);
				})
				->leftJoin('grades as g', 'g.id', '=', 'cg2.grade_id')
				->leftJoin('student_modules as sm', function ($left_join) use ($student_id) {
					$left_join->on('sm.module_id', '=', 'm.id')
						->on('sm.student_id', '=',
							DB::raw($student_id))
						->on('sm.module_status', '<>',
							DB::raw("'" .config('futureed.module_status_failed')."'"));
				})
				->leftJoin('student_modules as smc', function ($left_join) use ($student_id) {
					$left_join->on('smc.module_id', '=', 'm.id')
						->on('smc.student_id', '=',
							DB::raw($student_id))
						->on('smc.module_status', '<>',
							DB::raw("'" .config('futureed.module_status_completed')."'"));
				})
				->leftJoin('student_modules as smo', function ($left_join) use ($student_id) {
					$left_join->on('smo.module_id', '=', 'm.id')
						->on('smo.student_id', '=',
							DB::raw($student_id))
						->on('smo.module_status', '<>',
							DB::raw("'" .config('futureed.module_status_ongoing')."'"));
				})
				->where('o.date_start', '<=', Carbon::now())
				->where('o.date_end', '>=', Carbon::now())
				->where('class_students.student_id','=',$student_id)
				->where('s.id','=',$subject_id)
				->groupBy('m.grade_id')
				->get();
		}catch ( \Exception $e){

			return $e->getMessage();
		}
	}


	/**
	 * Student Progress by Subject group by Curriculum by grade.
	 * @param $student_id
	 * @param $subject_id
	 * @param $class_id
	 * @return bool
	 */
	public function getStudentSubjectProgressByCurriculum($student_id, $subject_id, $class_id){
		//-- Getting every row on every subject area - FINAL
		//select
		//s.name as subject_name,sa.id as area_id, sa.name as area_name, m.grade_id, sm.class_id, sm.student_id, sm.module_status, sm.progress, sm.updated_at
		//from subjects s
		//left join subject_areas sa on sa.subject_id=s.id
		//left join modules m on m.subject_area_id=sa.id
		//left join student_modules sm on sm.module_id=m.id and sm.module_status <> 'Failed' and sm.deleted_at is null
		//where sm.student_id = 1 -- student_module.student_id
		//and sa.id = 1 -- subject_area.id
		//and sm.class_id =1 -- student_module.class_id data from verified classrooms
		//group by m.grade_id
		//order by sa.name,m.grade_id
		//;
		//

		DB::beginTransaction();
		try{

			$response = Subject::select(
				DB::raw('s.name as subject_name'),
				DB::raw('sa.id as area_id'),
				DB::raw('sa.name as area_name'),
				DB::raw('m.grade_id'),
				DB::raw('sm.class_id'),
				DB::raw('sm.student_id'),
				DB::raw('sm.module_status'),
				DB::raw('sm.progress')
			)->leftJoin('subject_areas as sa','sa.subject_id','=','subject.id')
				->leftJoin('modules as m','m.subject_area_id','=','sa.id')
				->leftJoin('student_modules as sm', function($left_join) {
					$left_join->on('sm.module_id','=','m.id.')
						->on('sm.module_status','<>',config('futureed.module_status_failed'))
					;
				})->where('sm.student_id','=',$student_id)
				->where('sa.id','=',$subject_id)
				->where('sm.class_id','=',$class_id)
				->groupBy('m.grade_id')
				->orderBy('sa.name')
				->orderBy('m.grade_id')
				->get()
			;
		}catch (\Exception $e){

			$this->errorLog($e->getMessage());

			DB::rollback();

			return false;
		}

		DB::commit();
		return $response;

	}

	/**
	 * Check class validation by order.
	 * @param $student_id
	 * @param $subject_id
	 * @return bool
	 */
	public function getStudentValidClassBySubject($student_id, $subject_id){
		//		-- Get valid class based on active class students.
		//select
		//cs.class_id, cs.student_id
		//,c.id as c_id,c.name as c_name,c.subject_id
		//,o.order_no as o_order_no
		//from class_students cs
		//left join classrooms c on c.id=cs.class_id
		//left join orders o on o.order_no = c.order_no
		//where
		//subject_id = 1 -- subject_id
		//		and cs.student_id=1 -- student_id
		//		and date(o.date_start) <= now()  and date(o.date_end) >= now()
		//		and o.payment_status = 'Paid'
		//order by o.updated_at desc
		//		;

		DB::beginTransaction();
		try{

			$response = ClassStudent::select(
				DB::raw('class_students.class_id'),
				DB::raw('class_students.student_id'),
				DB::raw('c.id as c_id'),
				DB::raw('c.name as c_name'),
				DB::raw('c.subject_id'),
				DB::raw('o.order_no as order_no')
			)->leftJoin('classrooms as c','c.id','=','class_students.class_id')
				->leftJoin('orders as o','o.order_no','=','c.order_no')
				->where('c.subject_id','=',$subject_id)
				->where('class_students.student_id','=',$student_id)
				->where('o.date_start', '<=', Carbon::now())
				->where('o.date_end', '>=', Carbon::now())
				->where('o.payment_status','=',config('futureed.paid'))
				->orderBy('o.updated_at','desc')
				->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return $e->getMessage();
		}
		DB::commit();

		return $response;

	}


}
