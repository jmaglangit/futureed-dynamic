<?php
namespace FutureEd\Models\Repository\StudentModuleAnswer;

use FutureEd\Models\Core\StudentModuleAnswer;

class StudentModuleAnswerRepository implements StudentModuleAnswerRepositoryInterface{

    /**
     * Add Student module answer.
     * @param $data
     * @return array|string
     */
    public function addStudentModuleAnswer($data){
        try{
            return StudentModuleAnswer::create($data);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

	/**
	 * Get student module answer.
	 * @param $student_id
	 * @param $module_id
	 */
	public function getStudentModuleAnswer($student_module_id, $module_id){

		return StudentModuleAnswer::with('question')->studentModuleId($student_module_id)
			->moduleId($module_id)
			->orderBySeqNo()
			->get();
	}
}