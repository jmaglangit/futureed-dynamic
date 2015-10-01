<?php
namespace FutureEd\Models\Repository\ClassStudent;

use Carbon\Carbon;
use FutureEd\Models\Core\ClassStudent;
use FutureEd\Models\Core\Classroom;
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

}
