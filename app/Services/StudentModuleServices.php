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
	public function checkAnswers($student_module_id, $module_id){


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

//				$last_answered = $answer->question_id;
			}

			//level is done and has wrong.. set wrong as next.
			for($i = 1 ; $i <= count($module_questions); $i++){

				$next_question = $this->levelQuestion($module_questions[$i],$i);

				if($next_question <> false){

					//return next question.
					return $next_question;

				}
			}

		} else {

			$question = $this->question->getQuestionFirst($module_id);

			//set to the first question
			$next_question = $question[0]->id;
		}


		return $next_question;
	}


	//parse each level
	public function levelQuestion($data, $difficulty){

		//get all correct answers count
		if($difficulty == 1 || $difficulty == 3	){

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

		//get first wrong question and return with id.
			//get array key
		$key = array_search(config('futureed.answer_status_wrong'),$data);

		return $key;



	}


	//TODO: output questions to take.
	public function getNextQuestion($student_module_id, $module_id){

		return $this->checkAnswers($student_module_id,$module_id);
	}

}