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
}