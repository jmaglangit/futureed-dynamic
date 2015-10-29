<?php

namespace FutureEd\Models\Repository\Question;

use FutureEd\Models\Core\Question;
use FutureEd\Models\Core\QuestionAnswer;
use Illuminate\Support\Facades\Session;
use League\Flysystem\Exception;


class QuestionRepository implements QuestionRepositoryInterface{

	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addQuestion($data){

		try {

			$question = Question::create($data);

		} catch(Exception $e) {

			return $e->getMessage();

		}

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

		$question = new Question();

		$count = 0;

		if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

			$count = $question->count();

		} else {


			if (count($criteria) > 0) {

				//check scope module_id
				if(isset($criteria['module_id'])){

					$question = $question->moduleId($criteria['module_id']);
				}

				//check scope questions_text
				if(isset($criteria['questions_text'])){

					$question = $question->questionText($criteria['questions_text']);
				}

				//check scope to question_type
				if(isset($criteria['question_type'])){

					$question = $question->questionType($criteria['question_type']);
				}
				if(isset($criteria['difficulty'])){

					$question = $question->difficulty($criteria['difficulty']);
				}


			}

			$count = $question->count();

			$question = $question->orderBySeqNo();

			//set offset to last_answered_question
			if(isset($criteria['last_answered_question_id'])){

				//get question_id's sequence number and set as $offset
				$question_id = $this->getQuestionSequenceNo($criteria['last_answered_question_id']);
				$offset = $question_id[0]->seq_no - 1;
			}


			if ($limit > 0 && $offset >= 0) {
				$question = $question->offset($offset)->limit($limit);
			}
		}

		$question = $question->with('questionAnswers');

		return ['total' => $count, 'records' => $question->get()->toArray()];

	}

	/**
	 * Get a record on Question.
	 * @param $id
	 * @return mixed
	 */
	public function viewQuestion($id){

		$question = new Question();

		$question = $question->with('module');
		$question = $question->find($id);
		return $question;

	}


	/**
	 * Delete a record.
	 * @param $id
	 * @return bool|null|string
	 * @throws \Exception
	 */
	public function deleteQuestion($id){

		try{

			return Question::find($id)
				->delete();

		}catch (Exception $e){

			return $e->getMessage();
		}
	}

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */

	public function updateQuestion($id,$data){

		try{

			return Question::find($id)
				->update($data);

		}catch (Exception $e){

			return $e->getMessage();
		}
	}

	/**
	 * Get number of row under module.
	 * @param $module_id
	 *
	 * @return int
	 */
	public function getQuestionCount($module_id){

		$question = new Question();
		$question = $question->moduleId($module_id);
		$count = $question->get()->count();

		return $count;
	}


	/**
	 * Get questions id and sequence number order sequence.
	 * @param $module_id
	 */
	public function getQuestionSequenceNos($module_id,$difficulty){

		return Question::select('id','seq_no')
			->moduleId($module_id)
			->difficulty($difficulty)
			->orderBySeqNo()
			->get();
	}

	/**
	 * Get sequence number.
	 * @param $module_id
	 * @param $id
	 */
	public function getQuestionSequenceNo($id){

		return Question::select('id','seq_no','module_id')
			->id($id)
			->get();

	}

	/**
	 * Get last sequence number.
	 * @param $module_id
	 */
	public function getLastSequence($module_id,$difficulty){

		$question = new Question();
		return $question->moduleId($module_id)
			->difficulty($difficulty)
			->orderBySeqNoDesc()
			->pluck('seq_no');
	}

	/**
	 * Update sequence.
	 * @param $module_id
	 * @param $sequence
	 */
	public function updateSequence($sequence){

		try{
			$data = $sequence;

			foreach($data as $seq => $list){

				Question::find($list->id)
					->update([
						'seq_no' => $list->seq_no
					]);
			}


		}catch(Exception $e){

			return $e->getMessage();
		}


	}


	/**
	 * Get question type.
	 * @param $id
	 * @return mixed
	 */
	public function getQuestionType($id){

		return Question::whereId($id)->pluck('question_type');
	}

	/**
	 * Get question answer.
	 * @param $id
	 * @return mixed
	 */
	public function getQuestionAnswer($id){

		session(['super_access' => 1]);
		$response =  Question::whereId($id)->pluck('answer');
		Session::forget('super_access');

		return $response;
	}

	/**
	 * Get points earned if correct.
	 * @param $id
	 */
	public function getQuestionPointsEarned($id){
		return Question::whereId($id)->pluck('points_earned');
	}

	/**
	 * Get questions by module.
	 * @param $module_id
	 */
	public function getQuestionsByModule($module_id){

		return Question::whereModuleId($module_id)
			->whereStatus(config('futureed.enabled'))
			->orderBySeqNo()->get();
	}

	/**
	 * Get questions by points to finish.
	 * @param $module_id
	 * @param $points_to_finish
	 */
	public function getQuestionByPointsToFinish($module_id, $points_to_finish){

		return Question::whereModuleId($module_id)
			->orderBySeqNo()->take($points_to_finish)->get();
	}

	/**
	 * GEt first question.
	 * @param $module_id
	 * @return mixed
	 */
	public function getQuestionFirst($module_id){

		return Question::whereModuleId($module_id)
			->orderBySeqNo()->take(1)->get();
	}

	/**
	 * @param $module_id
	 */
	public function getQuestionLevelsByModule($module_id){

		return Question::whereModuleId($module_id)
			->groupBy('difficulty')
			->get();
	}

	/**
	 * @param $module_id
	 * @param $difficulty
	 * @return mixed
	 */
	public function countQuestions($module_id,$difficulty){

		return Question::whereModuleId($module_id)
			->whereDifficulty($difficulty)
			->count();
	}


}