<?php namespace FutureEd\Models\Repository\StudentModule;

use FutureEd\Models\Core\StudentModule;

class StudentModuleRepository implements StudentModuleRepositoryInterface{


    /**
     * Add new Student Module
     * @param $data
     * @return object
     */
    public function addStudentModule($data){
        try{
            return StudentModule::create($data);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Get Student Module
     * @param $id
     * @return object
     */
    public function getStudentModule($id){
        try{
            return StudentModule::find($id);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function updateStudentModule($id,$data){
        try{
            $result = StudentModule::find($id);
            return is_null($result) ? false : $result->update($data);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

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
	 * count the number of module under a subject of a student.
	 * @param array $criteria;
	 * @return count
	 */
	public function countSubjectModuleDone($criteria = array()){

		$student_module = new StudentModule();
		$student_module = $student_module->studentId($criteria['student_id']);
		$student_module = $student_module->progress($criteria['progress']);
		$student_module = $student_module->subjectId($criteria['subject_id']);
		$student_module = $student_module->gradeId($criteria['grade_id']);
		$student_module = $student_module->with('module');
		return $student_module->count();


	}


}