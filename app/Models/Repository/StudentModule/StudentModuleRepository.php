<?php namespace FutureEd\Models\Repository\StudentModule;

use Carbon\Carbon;
use FutureEd\Models\Core\Student;
use FutureEd\Models\Core\StudentModule;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class StudentModuleRepository implements StudentModuleRepositoryInterface
{

	use LoggerTrait;

	/**
	 * Add new Student Module
	 * @param $data
	 * @return object
	 */
	public function addStudentModule($data)
	{
		DB::beginTransaction();

		try {

			$response = StudentModule::create($data);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Student Module
	 * @param $id
	 * @return object
	 */
	public function getStudentModule($id)
	{
		DB::beginTransaction();

		try {

			$response = StudentModule::find($id);

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
	 * @param $data
	 * @return \Illuminate\Support\Collection|null|string|static
	 */
	public function updateStudentModule($id, $data)
	{
		DB::beginTransaction();

		try {

			StudentModule::whereId($id)
				->update([
					'module_status' => $data->module_status,
					'progress' => $data->progress,
					'date_start' => Carbon::parse($data->date_start),
					'date_end' => Carbon::parse($data->date_end),
					'total_time' => $data->total_time,
					'question_counter' => $data->question_counter,
					'wrong_counter' => $data->wrong_counter,
					'correct_counter' => $data->correct_counter,
					'running_points' => $data->running_points,
					'points_earned' => $data->points_earned,
					'last_viewed_content_id' => $data->last_viewed_content_id,
					'last_answered_question_id' => $data->last_answered_question_id,
					'total_correct_answer' => $data->total_correct_answer,
					'current_difficulty_level' => $data->current_difficulty_level
				]);

			$response = StudentModule::find($id);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get a record on StudentModule.
	 * @param $id
	 * @return mixed
	 */
	public function viewStudentModule($id)
	{
		DB::beginTransaction();

		try {

			$response = StudentModule::with('question')->find($id);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * count the number of module under a subject of a student.
	 * @param array $criteria ;
	 * @return count
	 */
	public function countSubjectModuleDone($criteria = array())
	{
		DB::beginTransaction();

		try {

			$student_module = new StudentModule();
			$student_module = $student_module->studentId($criteria['student_id']);
			$student_module = $student_module->progress($criteria['progress']);
			$student_module = $student_module->subjectId($criteria['subject_id']);
			$student_module = $student_module->gradeId($criteria['grade_id']);
			$student_module = $student_module->with('module');
			$response = $student_module->count();

			} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Student Module Status.
	 * @param $id
	 * @return mixed
	 */
	public function getStudentModuleStatus($id){

		DB::beginTransaction();

		try {

			$return = StudentModule::find($id);

			$response = $return->module_status;

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Updated Student last activities.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */
	public function updateStudentActivity($id,$data){

		DB::beginTransaction();

		$student_module = $this->getStudentModule($id);

		try{
			$response = StudentModule::find($id)
				->update([
					'last_viewed_content_id' => ($data['last_viewed_content_id'])
						? $data['last_viewed_content_id'] : $student_module->last_viewed_content_id,
					'last_answered_question_id' => ($data['last_answered_question_id'])
						? $data['last_answered_question_id'] : $student_module->last_answered_question_id
				]);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Wrong count.
	 * @param $id
	 * @return bool|mixed
	 */
	public function getStudentModuleWrongCount($id){

		DB::beginTransaction();

		try {

			$return = StudentModule::find($id);

			$response = $return->wrong_counter;

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Student Module by Student and Class
	 * @param $student_id
	 * @param $class_id
	 * @return bool
	 */
	public function getStudentModuleByClass($student_id, $class_id){

		DB::beginTransaction();

		try {

			$class_id = (array)$class_id;

			$response = StudentModule::with('subject')
				->studentId($student_id)
				->classId($class_id)
				->get();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Delete Student Module.
	 * @param $id
	 * @return bool|null
	 */
	public function deleteStudentModule($id){

		DB::beginTransaction();

		try{

			$response = StudentModule::find($id)->delete();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $class_id
	 * @return string
	 */
	public function getStudentModuleByClassId($class_id){

		DB::beginTransaction();
		try{

			$response = StudentModule::select(
				'id'
				,'class_id'
				,'student_id'
				,DB::raw('((sum(progress) /(count(progress) * 100)) * 100 ) as progress')
			)->with('student')
				->classId($class_id)
				->notFailed()
				->groupBy('student_id')
				->get();

		}catch (\Exception $e){
			DB::rollback();

			$this->errorLog($e->getMessage());

			return $e->getMessage();
		}

		DB::commit();

		return $response;

	}

	/**
	 * Get Student Module Grade By Student, Subject, and Grade.
	 * @param $student_id
	 * @param $subject_id
	 * @param $grade_id
	 * @return string
	 */
	public function getStudentModuleGradeCompleted($student_id, $subject_id, $grade_id){

		DB::beginTransaction();
		try{

			$response = StudentModule::studentId($student_id)
				->subjectId($subject_id)
				->gradeId($grade_id)
				->completed()
				->groupBy('module_id')
				->get();

		}catch (\Exception $e){
			DB::rollback();

			$this->errorLog($e->getMessage());

			return $e->getMessage();
		}

		DB::commit();
		return $response;
	}

	/**
	 * Get student module_status.
	 * @param $module_id
	 * @param $student_id
	 * @return bool
	 */
	public function getStudentModuleStatusByModuleStudent($module_id, $student_id){

		DB::beginTransaction();
		try{

			$response = StudentModule::with('classroom_order')
				->validClass()
				->studentId($student_id)
				->moduleId($module_id)
				->pluck('module_status');

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}
		DB::commit();

		return $response;
	}
}