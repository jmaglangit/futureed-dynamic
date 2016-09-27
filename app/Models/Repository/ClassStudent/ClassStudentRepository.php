<?php
namespace FutureEd\Models\Repository\ClassStudent;

use Carbon\Carbon;
use FutureEd\Models\Core\ClassStudent;
use FutureEd\Models\Core\Classroom;
use FutureEd\Models\Core\Subject;
use FutureEd\Models\Repository\Module\ModuleRepository as ModuleRepository;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use FutureEd\Models\Traits\LoggerTrait;

class ClassStudentRepository implements ClassStudentRepositoryInterface
{
	use LoggerTrait;

	/**
	 * @var ModuleRepository
	 */
	protected $module;

	protected $student_module;

	/**
	 * @param ModuleRepository $moduleRepository
	 * @param StudentModuleRepositoryInterface $studentModuleRepositoryInterface
	 */
	public function __construct(
		ModuleRepository $moduleRepository,
		StudentModuleRepositoryInterface $studentModuleRepositoryInterface
	){
		$this->module = $moduleRepository;
		$this->student_module = $studentModuleRepositoryInterface;

	}
	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getClassStudents($criteria = [], $limit = 0, $offset = 0)
	{
		DB::beginTransaction();

		try{
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

			$response = [
				'total' => $count,
				'records' => $records
			];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $student_id
	 * @return mixed
	 */
	public function getClassStudent($student_id)
	{
		DB::beginTransaction();

		try{
			$response = ClassStudent::where('student_id', $student_id)
							->with('classroom')
							->active()
							->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $class_student
	 * @return array|string
	 */
	public function addClassStudent($class_student)
	{
		DB::beginTransaction();

		try{
			$response = ClassStudent::create($class_student)->toArray();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */

	public function updateClassStudent($id, $class_student)
	{
		DB::beginTransaction();

		try{
			$response = ClassStudent::find($id)
				->update($class_student);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * @param $id
	 * @return bool|null
	 */
	public function deleteClassStudent($id)
	{
		try {
			$class_student = ClassStudent::find($id);
			$response = is_null($class_student) ? null : $class_student->delete();
		}catch (\Exception $e) {
			$this->errorLog($e->getMessage());
			return false;
		}

		return $response;
	}

	/**
	 * @param $class_id
	 * @return array|null
	 */
	public function getClassroom($class_id)
	{
		DB::beginTransaction();

		try{
			$classroom = Classroom::find($class_id);
			$response = !is_null($classroom) ? $classroom->toArray() : null;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $student_id
	 * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
	 */
	public function getStudentCurrentClassroom($student_id)
	{
		DB::beginTransaction();

		try{
			$response = ClassStudent::with('classroom')
							->studentid($student_id)
							->active()
							->currentdate(Carbon::now())
							->first();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Active Class Student by student_id
	 * @param $student_id
	 */
	public function getActiveClassStudent($student_id)
	{
		DB::beginTransaction();

		try{
			$response = ClassStudent::with('classroom')
							->studentId($student_id)
							->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Set to Inactive Class.
	 * @param $id
	 */
	public function setClassStudentInactive($id)
	{
		DB::beginTransaction();

		try{
			$response = ClassStudent::id($id)
							->update([
								'subscription_status' => config('futureed.inactive')
							]);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Inactive Student Class has date today.
	 * @param $student_id
	 */
	public function getInactiveClassStudent($student_id)
	{
		DB::beginTransaction();

		try{
			$response = ClassStudent::with('classroom')
							->studentId($student_id)
							->currentDate(Carbon::now())
							->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Set Class student to Active.
	 * @param $id
	 */
	public function setClassStudentActive($id)
	{
		DB::beginTransaction();

		try {
			$response = ClassStudent::id($id)
							->update([
								'subscription_status' => config('futureed.active')
							]);
		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Check if student is Enrolled in a class.
	 * @param $student_id,$class_id
	 */
	public function isEnrolled($student_id,$class_id)
	{
		DB::beginTransaction();

		try{
			$class_student = new  ClassStudent();
			$class_student = $class_student->studentId($student_id)->classroom($class_id);

			$response = $class_student->first();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * get the class student record by class_id.
	 * @param $student_id,$class_id
	 */
	public function getClassStudentByClassId($class_id)
	{
		DB::beginTransaction();

		try{
			$class_student = new  ClassStudent();
			$class_student = $class_student->where('class_id',$class_id);
			$response = $class_student->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * get the class student record by id.
	 * @param $id
	 */
	public function getClassStudentById($id)
	{
		DB::beginTransaction();

		try{
			$class_student = new  ClassStudent();
			$class_student = $class_student->with('student','classroom')->find($id);
			$response = $class_student;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}


	/**
	 * Get Current student class.
	 * @param $criteria
	 * @return mixed
	 */
	public function getCurrentClassStudent($criteria){
		DB::beginTransaction();

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

				$response = $subject;

			} else {

				$response = null;
			}

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

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
					 ->whereNULL('student_modules.deleted_at')
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

		DB::beginTransaction();
		try {

			$modules =  ClassStudent::select(
				DB::raw('m.grade_id as m_grade_id'),
				DB::raw('s.id as s_id'),
				DB::raw('s.name as s_name'),
				DB::raw('m.id as m_id'),
				DB::raw('m.name as m_name')
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
				->where('o.date_start', '<=', Carbon::now())
				->where('o.date_end', '>=', Carbon::now())
				->where('class_students.student_id','=',$student_id)
				->where('s.id','=',$subject_id)
				->get()
				;

			$progress =  ClassStudent::select(
				DB::raw('m.grade_id as grade_id'),
				DB::raw('count(m.id) as module_count'),
				DB::raw('(0) as completed'),
				DB::raw('(0) as on_going'),
				DB::raw('(0) as failed')
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
				->where('o.date_start', '<=', Carbon::now())
				->where('o.date_end', '>=', Carbon::now())
				->where('class_students.student_id','=',$student_id)
				->where('s.id','=',$subject_id)
				->groupBy('m.grade_id')
				->get()
			;

			foreach($modules as $module){

				$status = $this->student_module->getStudentModuleStatusByModuleStudent($module->m_id, $student_id);

				foreach($progress as $result){

					if($module->m_grade_id == $result->grade_id){

						switch($status){

							case config('futureed.module_status_completed'):

								$result->completed = $result->completed + 1;
								break;
							case config('futureed.module_status_ongoing'):

								$result->on_going = $result->on_going + 1;
								break;
							case config('futureed.module_status_failed'):

								$result->failed = $result->failed + 1;

								break;
							default:

								break;
						}
					}
				}
			}

		}catch ( \Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $progress;

	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @param $country_id
	 * @return string
	 */
	public function getStudentModulesCompleted($student_id,$subject_id, $country_id){

		DB::beginTransaction();
		try {

			$response =  ClassStudent::select(
				DB::raw('class_students.id'),
				DB::raw('smc.*')
			)->leftJoin('classrooms as c', 'c.id', '=', 'class_students.class_id')
				->leftJoin('orders as o', 'o.order_no', '=', 'c.order_no')
				->leftJoin('subjects as s', 's.id', '=', 'c.subject_id')
				->leftJoin('modules as m', 'm.subject_id', '=', 's.id')
				->leftJoin('student_modules as smc', function ($left_join) use ($student_id) {
					$left_join->on('smc.module_id', '=', 'm.id')
						->on('smc.student_id', '=',
							DB::raw($student_id))
						->whereNull('smc.deleted_at');
				})
				->where('o.date_start', '<=', Carbon::now())
				->where('o.date_end', '>=', Carbon::now())
				->where('class_students.student_id','=',$student_id)
				->where('smc.subject_id','=',$subject_id)
				->whereNotNull('smc.id')
				->where('smc.module_status',
					DB::raw("'" .config('futureed.module_status_completed')."'"))
				->get();

		}catch ( \Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @param $country_id
	 * @return string
	 */
	public function getStudentModulesTotalHours($student_id,$subject_id, $country_id){

		DB::beginTransaction();
		try {

			$response =  ClassStudent::select(
				DB::raw('sum(smc.total_time) as total_time')
			)->leftJoin('classrooms as c', 'c.id', '=', 'class_students.class_id')
				->leftJoin('orders as o', 'o.order_no', '=', 'c.order_no')
				->leftJoin('subjects as s', 's.id', '=', 'c.subject_id')
				->leftJoin('modules as m', 'm.subject_id', '=', 's.id')
				->leftJoin('student_modules as smc', function ($left_join) use ($student_id) {
					$left_join->on('smc.module_id', '=', 'm.id')
						->on('smc.student_id', '=',
							DB::raw($student_id));
				})
				->where('o.date_start', '<=', Carbon::now())
				->where('o.date_end', '>=', Carbon::now())
				->where('class_students.student_id','=',$student_id)
				->where('s.id','=',$subject_id)
				->whereNotNull('smc.id')
				->groupBy('class_students.id')
				->get();

		}catch ( \Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @param $country_id
	 * @return bool
	 */
	public function getStudentModulesWeekHours($student_id,$subject_id, $country_id){

		DB::beginTransaction();
		try {

			DB::enableQueryLog();
			$response =  ClassStudent::select(
				DB::raw('sum(sma.total_time) as total_time')
			)->leftJoin('classrooms as c', 'c.id', '=', 'class_students.class_id')
				->leftJoin('orders as o', 'o.order_no', '=', 'c.order_no')
				->leftJoin('subjects as s', 's.id', '=', 'c.subject_id')
				->leftJoin('modules as m', 'm.subject_id', '=', 's.id')
				->leftJoin('student_modules as smc', function ($left_join) use ($student_id) {
					$left_join->on('smc.module_id', '=', 'm.id')
						->on('smc.student_id', '=',
							DB::raw($student_id));
				})->leftJoin('student_module_answers as sma','sma.student_module_id','=','smc.id')
				->where('o.date_start', '<=', Carbon::now())
				->where('o.date_end', '>=', Carbon::now())
				->where('class_students.student_id','=',$student_id)
				->where('s.id','=',$subject_id)
				->where('sma.date_start', '>=', Carbon::now()->subWeek())
				->where('sma.date_end','<=', Carbon::now())
				->whereNotNull('smc.id')
				->groupBy('class_students.id')
				->get();


		}catch ( \Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
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
				DB::raw('subjects.name as subject_name'),
				DB::raw('sa.id as area_id'),
				DB::raw('sa.name as area_name'),
				DB::raw('m.grade_id'),
				DB::raw('sm.class_id'),
				DB::raw('sm.student_id'),
				DB::raw('sm.module_status'),
				DB::raw('sm.progress'),
				DB::raw('round(((sm.correct_counter/sm.question_counter) * 100),0) as heat_map'),
				DB::raw('sm.question_counter'),
				DB::raw('sm.correct_counter')
			)->leftJoin('subject_areas as sa','sa.subject_id','=','subjects.id')
				->leftJoin('modules as m','m.subject_area_id','=','sa.id')
				->leftJoin('student_modules as sm', function($left_join) {
					$left_join->on('sm.module_id','=','m.id')
						->on('sm.module_status', '<>',
							DB::raw("'" .config('futureed.module_status_failed')."'"))
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

			DB::rollback();

			$this->errorLog($e->getMessage());

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

			return false;
		}
		DB::commit();

		return $response;

	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @param $country_id
	 * @return string
	 */
	public function getStudentCurrentLearning($student_id,$subject_id, $country_id){
			//		select
			//m.grade_id as m_grade_id
			//,sa.name as subject_area
			//,sm.class_id, sm.subject_id,sm.module_id, sm.module_status, sm.progress
			//
			//from class_students cs
			//left join classrooms c on c.id=cs.class_id
			//left join subjects s on s.id=c.subject_id
			//left join subject_areas sa on sa.subject_id = s.id
			//left join modules m on m.subject_area_id = sa.id
			//left join student_modules sm on sm.module_id = m.id
			//		and sm.module_status <> 'Failed'
			//		and sm.deleted_at is null
			//		and sm.student_id = 3
			//left join students st on st.id = cs.student_id
			//where
			//cs.student_id = 3
			//and s.id = 1
			//and cs.subscription_status = 'Active'
			//group by m_grade_id, subject_area
			//order by m_grade_id asc, subject_area asc
			//		;

		DB::beginTransaction();
		try{

			$response = DB::table('class_students as cs')->select(
				DB::raw('m.id as module_id'),
				DB::raw('m.grade_id'),
				DB::raw('m.icon_image'),
				DB::raw('g.name as grade_name'),
				DB::raw('sa.name'),
				DB::raw('sm.progress')
			)->leftJoin('classrooms as c','c.id','=','cs.class_id')
				->leftJoin('subjects as s','s.id','=','c.subject_id')
				->leftJoin('subject_areas as sa', function($left_join){
					$left_join->on('sa.subject_id','=','s.id')
						->whereNull('sa.deleted_at');
				})
				->leftJoin('modules as m','m.subject_area_id','=','sa.id')
				->leftJoin('student_modules as sm',function($left_join) use ($student_id) {
					$left_join->on('sm.module_id','=','m.id')
						->on('sm.module_status','<>',DB::raw("'".config('futureed.module_status_failed')."'"))
						->whereNULL('sm.deleted_at')
						->where('sm.student_id','=',DB::raw($student_id));
				})->leftJoin('students as st','st.id','=','cs.student_id')
				->leftJoin('country_grades as cg', 'cg.grade_id', '=', 'm.grade_id')
				->leftJoin('country_grades as cg2', function ($left_join) use ($country_id) {
					$left_join->on('cg2.age_group_id', '=', 'cg.age_group_id')
						->on('cg2.country_id','=',
							DB::raw($country_id)
						);
				})
				->leftJoin('grades as g', 'g.id', '=', 'cg2.grade_id')
				->where('cs.student_id',DB::raw($student_id))
				->where('s.id',DB::raw($subject_id))
				->where('cs.subscription_status',DB::raw("'".config('futureed.active')."'"))
				->groupBy('grade_id','name')
				->orderBy('grade_id','asc')
				->orderBy('name','asc')
				->get()
				;


		}catch (\Exception $e){
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get modules listed on the classroom.
	 * @param $student_id
	 * @param $module_id
	 * @return bool
	 */
	public function getStudentValidModule($student_id, $module_id){

		DB::beginTransaction();
		try{

			$response = ClassStudent::with('student_classroom_module')->module($module_id)->get();
		}catch (Exception $e){
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}


}
