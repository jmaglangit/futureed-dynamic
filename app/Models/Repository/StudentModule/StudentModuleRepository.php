<?php namespace FutureEd\Models\Repository\StudentModule;

use Carbon\Carbon;
use FutureEd\Models\Core\Student;
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