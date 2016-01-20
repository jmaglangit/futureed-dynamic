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

        DB::beginTransaction();

        try{

            $response = StudentModuleAnswer::create($data);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Get student module answer.
     * @param $student_module_id
     * @param $module_id
     * @return bool
     * @internal param $student_id
     */
	public function getStudentModuleAnswer($student_module_id, $module_id){

        DB::beginTransaction();

        try {

            $response = StudentModuleAnswer::with('question')->studentModuleId($student_module_id)
                ->moduleId($module_id)
                ->orderBySeqNo()
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