<?php namespace FutureEd\Models\Repository\StudentModule;

use Carbon\Carbon;
use FutureEd\Models\Core\Student;
use FutureEd\Models\Core\StudentModule;

class StudentModuleRepository implements StudentModuleRepositoryInterface
{


	/**
	 * Add new Student Module
	 * @param $data
	 * @return object
	 */
	public function addStudentModule($data)
	{
		try {
			return StudentModule::create($data);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	/**
	 * Get Student Module
	 * @param $id
	 * @return object
	 */
	public function getStudentModule($id)
	{
		try {
			return StudentModule::find($id);
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function updateStudentModule($id, $data)
	{
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

			return StudentModule::find($id);

		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	/**
	 * Get a record on StudentModule.
	 * @param $id
	 * @return mixed
	 */
	public function viewStudentModule($id)
	{

		return StudentModule::with('question')->find($id);
	}

	/**
	 * count the number of module under a subject of a student.
	 * @param array $criteria ;
	 * @return count
	 */
	public function countSubjectModuleDone($criteria = array())
	{

		$student_module = new StudentModule();
		$student_module = $student_module->studentId($criteria['student_id']);
		$student_module = $student_module->progress($criteria['progress']);
		$student_module = $student_module->subjectId($criteria['subject_id']);
		$student_module = $student_module->gradeId($criteria['grade_id']);
		$student_module = $student_module->with('module');
		return $student_module->count();
	}

	/**
	 * Get Student Module Status.
	 * @param $id
	 */
	public function getStudentModuleStatus($id){

		$return = StudentModule::find($id);

		return $return->module_status;
	}

	/**
	 * Updated Student last activities.
	 * @param $id
	 * @param $data
	 */
	public function updateStudentActivity($id,$data){

		$student_module = $this->getStudentModule($id);

		try{
			return StudentModule::find($id)
				->update([
					'last_viewed_content_id' => isset($data['last_viewed_content_id'])
						? $data['last_viewed_content_id'] : $student_module->last_viewed_content_id,
					'last_answered_question_id' => isset($data['last_answered_question_id'])
						? $data['last_answered_question_id'] : $student_module->last_answered_question_id
				]);

		} catch(\Exception $e){

			return $e->getMessage();
		}
	}

	/**
	 * Get Wrong count.
	 * @param $id
	 */
	public function getStudentModuleWrongCount($id){

		$return  = StudentModule::find($id);

		return $return->wrong_counter;

	}

	/**
	 * Get Student Module by Student and Class
	 * @param $student_id
	 * @param $class_id
	 */
	public function getStudentModuleByClass($student_id, $class_id){

		$class_id = (array) $class_id;

		return StudentModule::with('subject')
			->studentId($student_id)
			->classId($class_id)
			->get();
	}

	/**
	 * Delete Student Module.
	 * @param $id
	 */
	public function deleteStudentModule($id){

		try{

			return StudentModule::find($id)->delete();

		} catch(\Exception $e){

			return $e->getMessage();
		}
	}




}