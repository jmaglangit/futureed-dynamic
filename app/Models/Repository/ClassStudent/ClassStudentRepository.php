<?php
namespace FutureEd\Models\Repository\ClassStudent;

use Carbon\Carbon;
use FutureEd\Models\Core\ClassStudent;
use FutureEd\Models\Core\Classroom;
use FutureEd\Models\Repository\User\UserRepository;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;

class ClassStudentRepository implements ClassStudentRepositoryInterface
{

	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getClassStudents($criteria = [], $limit = 0, $offset = 0)
	{


		$class_student = new ClassStudent();

		$class_student = $class_student->with('student');
//        dd($class_student->get()->toArray());
		if (isset($criteria['class_id'])) {

			$class_student = $class_student->classroom($criteria['class_id']);
		}

		if (isset($criteria['name'])) {

			$class_student = $class_student->name($criteria['name']);
		}

		if (isset($criteria['email'])) {

			$class_student = $class_student->email($criteria['email']);
		}

		if ($offset > 0 && $limit > 0) {

			$class_student = $class_student->skip($offset)->take($limit);
		}

		$records = $class_student->get();
		$count = $class_student->get()->count();

		return [
			'total' => $count,
			'record' => $records
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

	public function updateClassStudent($id, $class_student)
	{

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

//		return ClassStudent::with('classroom')
//			->studentid($student_id)
//			->active()
//			->currentdate(Carbon::now())
//			->first();

		return ClassStudent::with('classroom')
			->studentid($student_id)
			->active()
			->currentdate(Carbon::now())
			->get();
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

}
