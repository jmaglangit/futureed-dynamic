<?php namespace FutureEd\Models\Repository\StudentModule;


use FutureEd\Models\Core\StudentModule;

class StudentModuleRepository implements StudentModuleRepositoryInterface{

	/**
	 * Get a record on StudentModule.
	 * @param $id
	 * @return mixed
	 */
	public function viewStudentModule($id){

		$student_module = new StudentModule();

		$student_module = $student_module->find($id);
		return $student_module;

	}

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */

	public function updateStudentModule($id,$data){

		try{

			return StudentModule::find($id)
				->update($data);

		}catch (Exception $e){

			return $e->getMessage();
		}
	}



}
