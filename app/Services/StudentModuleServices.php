<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use FutureEd\Models\Repository\StudentModuleAnswer\StudentModuleAnswerRepositoryInterface;

class StudentModuleServices {

	/**
	 * @var ModuleRepositoryInterface
	 */
	protected $module;

	/**
	 * @var QuestionRepositoryInterface
	 */
	protected $question;

	/**
	 * @var StudentModuleAnswerRepositoryInterface
	 */
	protected $student_module_answer;

	/**
	 * @var StudentModuleRepositoryInterface
	 */
	protected $student_module;

	/**
	 * @var int
	 */
	protected $stuck = 0;

	/**
	 * @var int
	 */
	protected $high_effort = 0;

	/**
	 * @var int
	 */
	protected $struggling = 0;

	/**
	 * @var int
	 */
	protected $excelling = 0;

	/**
	 * @param ModuleRepositoryInterface $moduleRepositoryInterface
	 * @param QuestionRepositoryInterface $questionRepositoryInterface
	 * @param StudentModuleAnswerRepositoryInterface $studentModuleAnswerRepositoryInterface
	 * @param StudentModuleRepositoryInterface $studentModuleRepositoryInterface
	 */
	public function __construct(
		ModuleRepositoryInterface $moduleRepositoryInterface,
		QuestionRepositoryInterface $questionRepositoryInterface,
		StudentModuleAnswerRepositoryInterface $studentModuleAnswerRepositoryInterface,
		StudentModuleRepositoryInterface $studentModuleRepositoryInterface
	){
		$this->module = $moduleRepositoryInterface;

		$this->question = $questionRepositoryInterface;

		$this->student_module_answer = $studentModuleAnswerRepositoryInterface;

		$this->student_module = $studentModuleRepositoryInterface;
	}

	//TODO: GET THE NEXT QUESTION

	//TODO: parse; get modules questions and levels
	/**
	 * @param $module_id
	 * @return array
	 */
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
	/**
	 * @param $student_module_id
	 * @param $module_id
	 * @return mixed
	 */
	public function getStudentModuleAnswer($student_module_id, $module_id){

		return $this->student_module_answer->getStudentModuleAnswer($student_module_id,$module_id);
	}

	//TODO: get module points to finish
	/**
	 * @param $module_id
	 * @return mixed
	 */
	public function getPointsToFinish($module_id){

		//points to finish is also the number of questions to finish; 1 question is 1 point.
		return $this->module->getPointsToFinish($module_id);
	}



	//TODO: merge module answer
	/**
	 * @param $student_module_id
	 * @param $module_id
	 * @param $student_answer
	 * @return int|mixed
	 */
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

					if($next_question <> false && $next_question <> -1){

						//return next question.
						return $next_question;

					}elseif($next_question == -1){

						return -1;
					}
				}
			}

		} else {

			$question = $this->question->getQuestionFirst($module_id);

			//set to the first question
			$next_question = $question[0]->id;

			return $next_question;
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

		//if question id in wrong answers.
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

			//Check if there are no wrong questions.
			if(empty($wrong_answers)){

				return $student_answer->question_id;
			}

			//else Answer is correct and get first next wrong question.

			current($data);

			//find the correct answer id.
			for($i=0; $i < count($data); $i++){

				if(key($data) <> $student_answer->question_id){
					next($data);

				} else{

					next($data);
					break;
				}
			}

			//Check if current is equal to wrong.
			for(;$i < count($data); $i++){

				if(current($data) <> config('futureed.answer_status_wrong')){

					next($data);
				}else {

					break;
				}
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

		return ($this->module->getModuleDifficulty($module_id)) ? $this->difficultyNextQuestion($student_module_id,$module_id)
			:$this->checkAnswers($student_module_id,$module_id,$student_answer);
	}

	/**
	 * @param $class_id
	 * @return array
	 */
	public function getStudentProgress($class_id){

		//Struggling = 20% and Below of the Progress of the Module Per Class
		//Excelling = 80% to 100% of the Progress of the Module Per Class
		//Stuck - if get more than 40% in module wrong and must redo (progress)
		//Mastered - If they get 80% above correct (progress)

		$standing = [];

		//get class id and student id
		$student_module = $this->student_module->getStudentModuleByClassId($class_id);

		foreach($student_module as $progress){

			$data = new \stdClass();

			$data->first_name = $progress->student->first_name;
			$data->last_name = $progress->student->last_name;
			$data->progress = $this->getProgressStatusConverter($progress);

			array_push($standing,$data);

		}

		return $standing;
	}

	/**
	 * @return int
	 */
	public function getStuck() {
		return $this->stuck;
	}

	/**
	 * @param int $stuck
	 */
	public function setStuck($stuck) {
		$this->stuck += $stuck;
	}

	/**
	 * @return int
	 */
	public function getHighEffort() {
		return $this->high_effort;
	}

	/**
	 * @param int $high_effort
	 */
	public function setHighEffort($high_effort) {
		$this->high_effort += $high_effort;
	}

	/**
	 * @return int
	 */
	public function getStruggling() {
		return $this->struggling;
	}

	/**
	 * @param int $struggling
	 */
	public function setStruggling($struggling) {
		$this->struggling += $struggling;
	}

	/**
	 * @return int
	 */
	public function getExcelling() {
		return $this->excelling;
	}

	/**
	 * @param int $excelling
	 */
	public function setExcelling($excelling) {
		$this->excelling += $excelling;
	}



	/**
	 * @param $progress_percentage
	 * @return mixed|null
	 */
	public function getProgressStatusConverter($progress){

		switch($progress->progress){

			//Struggling 20 and below
			case $progress->progress <= 20:

				$this->setStruggling(1);
				return config('futureed.student_struggling');
				break;

			//Excelling and Mastering/High Effort
			case $progress->progress >= 80 && $progress->progress <= 100:

				$this->setHighEffort(1);
				$this->setExcelling(1);
				return config('futureed.student_excelling');
				break;

			//None
			default:

				$this->setStuck(1);
				return null;
				break;
		}

	}

	/**
	 * Check for existing questions.
	 * @param $student_module_id
	 * @param $module_id
	 */
	public function checkEnabledQuestions($student_module_id, $module_id){

		$module_answers = $this->student_module_answer->getStudentModuleAnswer($student_module_id,$module_id);

		foreach($module_answers as $answer){

			if(is_null($answer->question)){

				//deleted question answer
				$this->student_module_answer->deletedStudentModuleAnswer($student_module_id,$answer->question_id);
			}
		}

	}

	/**
	 * fill in the blanks or enumerate match answers in order, $answer is comma separated, $correct in object
	 * @param $answer
	 * @param $correct
	 * @return bool
	 */
	public function answerOrdering($answer,$correct){

		//elimination order if matched
		//match by key value

		$answer_values = explode(",",$answer);

		$func = function($item){
			return $item->value;
		};

		$correct_values = array_map($func,$correct);

		$match_values = function($item1,$item2){
			return ($item1 == $item2);
		};

		if(count($answer_values) == count($correct_values)){
			for($i=0;$i < count($correct); $i++){
				if(!$match_values($answer_values[$i],$correct_values[$i])){
					return false;
				}
			}
		} else {
			return false;
		}

		return true;
	}

	/**
	 * fill in the blanks or enumerate match answer in any order, $answer is comma separated, $correct in object
	 * @param $answer
	 * @param $correct
	 * @return bool
	 */
	public function answerInterchange($answer,$correct){

		//elimination if matched
		//use array_intersect

		$answer_values = explode(",",$answer);

		$func = function($item){
			return $item->value;
		};

		$correct_values = array_map($func,$correct);

		$match_values = function($item1,$item2){
			return in_array($item1,$item2);
		};

		if(count($answer_values) == count($correct)){
			for($i=0;$i < count($correct); $i++){
				if(!$match_values($answer_values[$i],$correct_values)){
					return false;
				}
			}
		} else {
			return false;
		}

		return true;
	}

	/**
	 * @param $student_module_id
	 * @param $module_id
	 * @return int
	 */
	public function difficultyNextQuestion($student_module_id,$module_id){

		//get student module answer
		$module_answers = $this->student_module_answer->getStudentModuleAnswer($student_module_id,$module_id)->toArray();

		//get list questions under the module
		$module_questions = $this->question->getQuestionsByModule($module_id);

		//parse data
		foreach($module_questions as $question){

			$answer_columns = array_column($module_answers,'question_id');

			if(!in_array($question->id,$answer_columns)){
				return $question->id;
			}
		}

		return -1;
	}

}