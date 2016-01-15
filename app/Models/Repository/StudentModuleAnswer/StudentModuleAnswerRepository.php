<?php
namespace FutureEd\Models\Repository\StudentModuleAnswer;

use FutureEd\Models\Core\StudentModuleAnswer;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class StudentModuleAnswerRepository implements StudentModuleAnswerRepositoryInterface{

    use LoggerTrait;

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

    /**
     * @param $student_module_id
     * @param $question_id
     * @return bool
     */
    public function deletedStudentModuleAnswer($student_module_id, $question_id){

        DB::beginTransaction();
        try{

            $response = StudentModuleAnswer::studentModuleId($student_module_id)
                ->questionId($question_id)->delete();

        }catch (\Exception $e){

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;

    }
}