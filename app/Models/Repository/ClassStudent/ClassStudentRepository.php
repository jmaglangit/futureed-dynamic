<?php
namespace FutureEd\Models\Repository\ClassStudent;

use Carbon\Carbon;
use FutureEd\Models\Core\ClassStudent;
use FutureEd\Models\Core\Classroom;
use FutureEd\Models\Repository\User\UserRepository;

class ClassStudentRepository implements ClassStudentRepositoryInterface{

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

			$class_student = $class_student->username($criteria['name']);
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

		return ClassStudent::where('student_id', $student_id)->pluck('student_id');
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

		return ClassStudent::with('classroom')
			->studentid($student_id)
			->currdate(Carbon::now())
			->first();
	}
}