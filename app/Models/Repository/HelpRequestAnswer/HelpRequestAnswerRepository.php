<?php namespace FutureEd\Models\Repository\HelpRequestAnswer;


use FutureEd\Models\Core\HelpRequestAnswer;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class HelpRequestAnswerRepository implements HelpRequestAnswerRepositoryInterface{
	use LoggerTrait;

	/**
	 * Gets list of Help Request Answers.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getHelpRequestAnswers($criteria,$limit,$offset){
		DB::beginTransaction();

		try{
			$help_request_answer = new HelpRequestAnswer();

			/*
			 * Filters:
			 * help_request
			 * module
			 * subject_area
			 * subject
			 * request_answer_status
			 * created_by
			 *
			 */

			if(isset($criteria['class_id'])){

				$help_request_answer = $help_request_answer->ClassId($criteria['class_id']);
			}

			if(isset($criteria['help_request'])){

				$help_request_answer = $help_request_answer->RequestTitle($criteria['help_request']);
			}

			if(isset($criteria['help_request_id'])){

				$help_request_answer = $help_request_answer->RequestId($criteria['help_request_id']);
			}

			if(isset($criteria['module'])){

				$help_request_answer = $help_request_answer->ModuleName($criteria['module']);

			}

			if(isset($criteria['subject'])){

				$help_request_answer = $help_request_answer->SubjectName($criteria['subject']);
			}

			if(isset($criteria['subject_area'])){

				$help_request_answer = $help_request_answer->SubjectAreaName($criteria['subject_area']);
			}

			if(isset($criteria['request_answer_status'])){

				$help_request_answer = $help_request_answer->AnswerStatus($criteria['request_answer_status']);

			}

			if(isset($criteria['status'])){

				$help_request_answer = $help_request_answer->status($criteria['status']);

			}

			if(isset($criteria['created_by'])){

				$help_request_answer = $help_request_answer->createdBy($criteria['created_by']);
			}

			$help_request_answer = $help_request_answer
				->with('student', 'helpRequest','module','subject','subjectArea','user')->where('request_answer_status','!=','Rejected');

			$count = $help_request_answer->count();


			if($limit > 0 && $offset >= 0) {
				$help_request_answer = $help_request_answer->offset($offset)->limit($limit);
			}

			$response = [
				'total' => $count,
				'records' => $help_request_answer->get()
			];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get a record on Help Request Answer.
	 * @param $id
	 * @return mixed
	 */
	public function getHelpRequestAnswer($id){
		DB::beginTransaction();

		try{
			$response = HelpRequestAnswer::with('helpRequest','module','subject','subjectArea','user')->find($id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */
	public function updateHelpRequestAnswer($id,$data){
		DB::beginTransaction();

		try {

			HelpRequestAnswer::find($id)
				->update($data);

			$response = $this->getHelpRequestAnswer($id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Delete a record.
	 * @param $id
	 * @return bool|null|string
	 * @throws \Exception
	 */
	public function deleteHelpRequestAnswer($id){
		DB::beginTransaction();

		try{

			$response = HelpRequestAnswer::find($id)
				->delete();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get a record on Help Request Answer by help_request_id.
	 * @param $id
	 * @return mixed
	 */
	public function getHelpRequestAnswerByHelpRequestId($help_request_id)
	{
		DB::beginTransaction();

		try{
			$response = HelpRequestAnswer::with('helpRequest', 'module', 'subject', 'subjectArea','user')->helpRequestId($help_request_id)->first();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update status.
	 * @param $id
	 * @param $status
	 * @return mixed|string
	 */
	public function updateRequestAnswerStatus($id,$status){
		DB::beginTransaction();

		try{
			HelpRequestAnswer::find($id)
				->update([
					'request_answer_status' => $status
				]);

			$response = $this->getHelpRequestAnswer($id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addHelpRequestAnswer($data){
		DB::beginTransaction();

		try{
			$response = HelpRequestAnswer::create($data)->toArray();
		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get answer by student id and asnwer id
	 * @param $student_id
	 * @param $help_request_answer_id
	 * @return null|string
	 */
	public function checkStudentHelpRequestAnswer($student_id,$help_request_answer_id){
		DB::beginTransaction();
		try{
			$result = HelpRequestAnswer::StudentId($student_id)->find($help_request_answer_id);
			$response = is_null($result) ? null : $result->toArray();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}