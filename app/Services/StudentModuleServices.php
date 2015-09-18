<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use FutureEd\Models\Repository\StudentModuleAnswer\StudentModuleAnswerRepositoryInterface;

class StudentModuleServices {

	protected $module;

	protected $question;

	protected $student_module_answer;


	public function __construct(
		ModuleRepositoryInterface $moduleRepositoryInterface,
		QuestionRepositoryInterface $questionRepositoryInterface,
		StudentModuleAnswerRepositoryInterface $studentModuleAnswerRepositoryInterface
	){
		$this->module = $moduleRepositoryInterface;

		$this->question = $questionRepositoryInterface;

		$this->student_module_answer = $studentModuleAnswerRepositoryInterface;

	}

	//TODO: GET THE NEXT QUESTION

	//TODO: parse; get modules questions and levels
	public function getModuleQuestions($module_id){

		//get points to finish.
		//$points_to_finish = $this->module->getPointsToFinish($module_id);

		//get module questions based on points to finish.
		//$questions =  $this->question->getQuestionByPointsToFinish($module_id,$points_to_finish);

		//get all module questions.
		$questions = $this->question->getQuestionsByModule($module_id);

		//parse question [difficulty][question]
		$question_set = [];

		foreach($questions as $question){

			$question_set[$question->difficulty][$question->id] = 0;

		}

		return $question_set;
	}

	//TODO: get answers from db
	public function getStudentModuleAnswer($student_module_id, $module_id){

		return $this->student_module_answer->getStudentModuleAnswer($student_module_id,$module_id);
	}

	//TODO: get module points to finish
	public function getPointsToFinish($module_id){

		//points to finish is also the number of questions to finish; 1 question is 1 point.
		return $this->module->getPointsToFinish($module_id);
	}



	//TODO: merge module answer
	public function checkAnswers($student_module_id, $module_id,$student_answer){


		//get module question with answer
		$module_questions = $this->getModuleQuestions($module_id);

		//get student module answer.
		$student_module_answer = $this->getStudentModuleAnswer($student_module_id, $module_id);


		//Initialized next question.
		$next_question = 0;

		if(!empty($student_module_answer->toArray())){

			$last_answered = 0;

			//fill in the answers until end if answer is not empty.
			foreach($student_module_answer as $answer){

				$module_questions[$answer->question->difficulty][$answer->question_id] = $answer->answer_status;

			}

			//Traps if Modules/Question set doesn't have either of levels 1,2, and 3.

			//level is done and has wrong.. set wrong as next.
			for($i = 1 ; $i <= count($module_questions); $i++){

				if(array_key_exists($i,$module_questions)){

					$next_question = $this->levelQuestion($module_questions[$i],$i, $student_answer);

					if($next_question <> false){

						//return next question.
						return $next_question;

					}
				}
			}

		} else {

			$question = $this->question->getQuestionFirst($module_id);

			//set to the first question
			$next_question = $question[0]->id;
		}

	}

	/**
	 * Get all wrong answers.
	 * @param $module_level_questions
	 * @return mixed
	 */
	public function getWrongAnswers($module_level_questions){

		while(array_search(config('futureed.answer_status_correct'), $module_level_questions)){
			$delete_key = array_search(config('futureed.answer_status_correct'), $module_level_questions);

			unset($module_level_questions[$delete_key]);
		}

		return $module_level_questions;


	}


	//parse each level
	/**
	 * Parse each level.
	 * @param $data
	 * @param $difficulty
	 * @param $student_answer
	 * @return mixed
	 */
	public function levelQuestion($data, $difficulty,$student_answer){

		//get all correct answers count
		if($difficulty == 1 || $difficulty == 2	){

			//check number of correct answers.
			$counts = array_count_values($data);

			$correct_limit = 4;


			if(array_key_exists(config('futureed.answer_status_correct'), $counts)){

				if($counts['Correct'] >= $correct_limit){

					return false;
				}
			}


		}

		//get first 0 question
		$zero = array_search(0,$data, true);

		if($zero <> false){

			return $zero;
		}

		$wrong_answers = $this->getWrongAnswers($data);

		//if question id in wrong.
		if(isset($wrong_answers[$student_answer->question_id])){

			//if question id is the last get first.
			end($wrong_answers);
			if($student_answer->question_id == key($wrong_answers)){

				reset($wrong_answers);

				return key($wrong_answers);

			}else {
				//parse through next of question id
				reset($wrong_answers);

				while(key($wrong_answers) <> $student_answer->question_id){

					next($wrong_answers);
				}

				next($wrong_answers);

				return key($wrong_answers);
			}

		}else {

			//else Answer is correct and get first next wrong question.
			current($data);

			//find the correct answer id.
			while(key($data) <> $student_answer->question_id){

				next($data);
			}

			next($data);

			//Check if current is equal to wrong.
			while(current($data) <> config('futureed.answer_status_wrong')){

				next($data);
			}

			return key($data);
		}

	}


	/**
	 * Output question to take.
	 * @param $student_module_id
	 * @param $module_id
	 * @param $student_answer
	 * @return int|mixed
	 */
	public function getNextQuestion($student_module_id, $module_id,$student_answer){

		return $this->checkAnswers($student_module_id,$module_id,$student_answer);
	}

}