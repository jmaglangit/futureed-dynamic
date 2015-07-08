<?php namespace FutureEd\Models\Repository\HelpRequestAnswer;


use FutureEd\Models\Core\HelpRequestAnswer;

class HelpRequestAnswerRepository implements HelpRequestAnswerRepositoryInterface{

	/**
	 * Gets list of Help Request Answers.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getHelpRequestAnswers($criteria,$limit,$offset){

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

		return [
			'total' => $count,
			'records' => $help_request_answer->get()
		];

	}

	/**
	 * Get a record on Help Request Answer.
	 * @param $id
	 * @return mixed
	 */
	public function getHelpRequestAnswer($id){

		return HelpRequestAnswer::with('helpRequest','module','subject','subjectArea','user')->find($id);

	}

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */
	public function updateHelpRequestAnswer($id,$data){

		try {

			HelpRequestAnswer::find($id)
				->update($data);

			return $this->getHelpRequestAnswer($id);

		} catch(Exception $e){

			return $e->getMessage();
		}
	}

	/**
	 * Delete a record.
	 * @param $id
	 * @return bool|null|string
	 * @throws \Exception
	 */
	public function deleteHelpRequestAnswer($id){

		try{

			return HelpRequestAnswer::find($id)
				->delete();

		}catch (Exception $e){

			return $e->getMessage();
		}
	}

	/**
	 * Get a record on Help Request Answer by help_request_id.
	 * @param $id
	 * @return mixed
	 */
	public function getHelpRequestAnswerByHelpRequestId($help_request_id)
	{
		return HelpRequestAnswer::with('helpRequest', 'module', 'subject', 'subjectArea','user')->helpRequestId($help_request_id)->first();
	}

	/**
	 * Update status.
	 * @param $id
	 * @param $status
	 * @return mixed|string
	 */
	public function updateRequestAnswerStatus($id,$status){

		try{
			HelpRequestAnswer::find($id)
				->update([
					'request_answer_status' => $status
				]);

			return $this->getHelpRequestAnswer($id);

		}catch (Exception $e){

			return $e->getMessage();
		}
	}

    /**
     * Add record in storage
     * @param $data
     * @return object
     */
    public function addHelpRequestAnswer($data){
        try{
            return HelpRequestAnswer::create($data)->toArray();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Get answer by student id and asnwer id
     * @param $student_id
     * @param $help_request_answer_id
     * @return null|string
     */
    public function checkStudentHelpRequestAnswer($student_id,$help_request_answer_id){
        try{
            $result = HelpRequestAnswer::StudentId($student_id)->find($help_request_answer_id);
            return is_null($result) ? null : $result->toArray();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }


}