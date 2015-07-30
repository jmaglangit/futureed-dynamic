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

		return StudentModule::with('question')->find($id);
    }
}