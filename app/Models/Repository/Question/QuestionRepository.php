<?php

namespace FutureEd\Models\Repository\Question;

use FutureEd\Models\Core\Question;
use FutureEd\Models\Core\QuestionAnswer;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use League\Flysystem\Exception;


class QuestionRepository implements QuestionRepositoryInterface{

	use LoggerTrait;

	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addQuestion($data){

		DB::beginTransaction();

		try {

			$question = Question::create($data);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $question;
	}


	/**
	 * Gets list of Questions.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getQuestions($criteria = array(), $limit = 0, $offset = 0){

		DB::beginTransaction();

		try {
			$question = new Question();

			$count = 0;

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $question->count();

			} else {


				if (count($criteria) > 0) {

					//check scope module_id
					if (isset($criteria['module_id'])) {

						$question = $question->moduleId($criteria['module_id']);
					}

					//check scope questions_text
					if (isset($criteria['questions_text'])) {

						$question = $question->questionText($criteria['questions_text']);
					}

					//check scope to question_type
					if (isset($criteria['question_type'])) {

						$question = $question->questionType($criteria['question_type']);
					}
					if (isset($criteria['difficulty'])) {

						$question = $question->difficulty($criteria['difficulty']);
					}
					if (isset($criteria['status'])) {

						$question = $question->status($criteria['status']);
					}


				}

				$count = $question->count();

				$question = $question->orderByDifficulty()->orderBySeqNo()->orderById();

				//set offset to last_answered_question
				if (isset($criteria['last_answered_question_id'])) {

					//get question_id's sequence number and set as $offset
					$question_id = $this->getQuestionSequenceNo($criteria['last_answered_question_id']);
					$offset = $question_id[0]->seq_no - 1;
				}


				if ($limit > 0 && $offset >= 0) {
					$question = $question->offset($offset)->limit($limit);
				}
			}

			$question = $question->with('questionAnswers');

			$response = ['total' => $count, 'records' => $question->get()->toArray()];

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get a record on Question.
	 * @param $id
	 * @return mixed
	 */
	public function viewQuestion($id){

		DB::beginTransaction();

		try {
			$question = new Question();

			$question = $question->with('module');
			$question = $question->find($id);

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $question;
	}


	/**
	 * Delete a record.
	 * @param $id
	 * @return bool|null|string
	 * @throws \Exception
	 */
	public function deleteQuestion($id){

		DB::beginTransaction();

		try{

			$response = Question::find($id)
				->delete();

		} catch (\Exception $e) {

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
	public function updateQuestion($id,$data){

		DB::beginTransaction();

		try{

			$response = Question::find($id)
				->update($data);

		}catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get number of row under module.
	 * @param $module_id
	 *
	 * @return int
	 */
	public function getQuestionCount($module_id){

		DB::beginTransaction();

		try {
			$question = new Question();
			$question = $question->moduleId($module_id);
			$count = $question->get()->count();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $count;
	}


	/**
	 * Get questions id and sequence number order sequence.
	 * @param $module_id
	 * @return bool
	 */
	public function getQuestionSequenceNos($module_id,$difficulty){

		DB::beginTransaction();

		try{
			$response = Question::select('id','seq_no')
				->moduleId($module_id)
				->difficulty($difficulty)
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
	 * Get sequence number.
	 * @param $id
	 * @return bool
	 * @internal param $module_id
	 */
	public function getQuestionSequenceNo($id){

		DB::beginTransaction();

		try {

			$response = Question::select('id', 'seq_no', 'module_id')
				->id($id)
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
	 * Get last sequence number.
	 * @param $module_id
	 * @return bool
	 */
	public function getLastSequence($module_id,$difficulty){

		DB::beginTransaction();

		try {

			$question = new Question();
			$response = $question->moduleId($module_id)
				->difficulty($difficulty)
				->orderBySeqNoDesc()
				->pluck('seq_no');

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update sequence.
	 * @param $sequence
	 * @return string
	 * @internal param $module_id
	 */
	public function updateSequence($sequence){

		DB::beginTransaction();

		try{
			$data = $sequence;

			foreach($data as $seq => $list){

				Question::find($list->id)
					->update([
						'seq_no' => $list->seq_no
					]);
			}

			$response = true;

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}


	/**
	 * Get question type.
	 * @param $id
	 * @return mixed
	 */
	public function getQuestionType($id){

		DB::beginTransaction();

		try {

			$response = Question::whereId($id)->pluck('question_type');

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get question answer.
	 * @param $id
	 * @return mixed
	 */
	public function getQuestionAnswer($id){

		DB::beginTransaction();

		try {

			session(['super_access' => 1]);
			$question = Question::find($id);

			$response = $question->answer;

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get points earned if correct.
	 * @param $id
	 * @return bool
	 */
	public function getQuestionPointsEarned($id){

		DB::beginTransaction();

		try {

			$response = Question::whereId($id)->pluck('points_earned');
		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get questions by module.
	 * @param $module_id
	 * @return bool
	 */
	public function getQuestionsByModule($module_id){

		DB::beginTransaction();

		try {

			$response = Question::whereModuleId($module_id)
				->whereStatus(config('futureed.enabled'))
				->orderBySeqNo()
				->whereBetween('difficulty', [1,3])
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
	 * Get questions by points to finish.
	 * @param $module_id
	 * @param $points_to_finish
	 */
	public function getQuestionByPointsToFinish($module_id, $points_to_finish){

		DB::beginTransaction();

		try {

			$response = Question::whereModuleId($module_id)
				->orderBySeqNo()->take($points_to_finish)->get();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * GEt first question.
	 * @param $module_id
	 * @return mixed
	 */
	public function getQuestionFirst($module_id){

		DB::beginTransaction();

		try {

			$response = Question::whereModuleId($module_id)
				->orderBySeqNo()->take(1)->get();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $module_id
	 * @return bool
	 */
	public function getQuestionLevelsByModule($module_id){

		DB::beginTransaction();

		try {

			$response = Question::whereModuleId($module_id)
				->groupBy('difficulty')
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
	 * @param $module_id
	 * @param $difficulty
	 * @return mixed
	 */
	public function countQuestions($module_id,$difficulty){

		DB::beginTransaction();

		try {

			$response = Question::whereModuleId($module_id)
				->whereDifficulty($difficulty)
				->count();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get enabled question
	 * @param $id
	 * @return mixed
	 */
	public function getEnabledQuestion($id){

		DB::beginTransaction();

		try {

			$response = Question::id($id)->status(config('futureed.enabled'))->get();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Graph questions.
	 * @param $id
	 * @return mixed
	 */
	public function getGraphQuestion($id){

		DB::beginTransaction();

		try {
			$question_types = [
				config('futureed.question_type_graph'),
				config('futureed.question_type_quad')
			];

			$response = Question::id($id)->questionType($question_types)->first();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Graph by Question Type.
	 * @param $id
	 * @param $question_type
	 * @return mixed
	 */
	public function getGraphQuestionByType($id, $question_type){

		DB::beginTransaction();

		try {

			$response = Question::id($id)->questionType($question_type)->first();

		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}


}