<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/21/17
 * Time: 10:31 AM
 */

namespace FutureEd\Services;

use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\ModuleQuestionTemplate\ModuleQuestionTemplateRepositoryInterface;
use FutureEd\Models\Repository\QuestionCache\QuestionCacheRepositoryInterface;
use FutureEd\Models\Repository\QuestionGradeCondition\QuestionGradeConditionRepositoryInterface;
use FutureEd\Models\Repository\QuestionTemplate\QuestionTemplateRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use FutureEd\Models\Repository\StudentModuleAnswer\StudentModuleAnswerRepositoryInterface;

class QuestionCacheServices {

	protected $module;

	protected $module_question_template;

	protected $question_template;

	protected $question_grade_condition;

	protected $question_cache;

	protected $equation_compiler;

	protected $student_module;

	protected $student_module_answer;


	public function __construct(
		ModuleRepositoryInterface $moduleRepositoryInterface,
		ModuleQuestionTemplateRepositoryInterface $moduleQuestionTemplateRepositoryInterface,
		QuestionTemplateRepositoryInterface $questionTemplateRepositoryInterface,
		QuestionGradeConditionRepositoryInterface $questionGradeConditionRepositoryInterface,
		QuestionCacheRepositoryInterface $questionCacheRepositoryInterface,
		EquationCompilerServices $equationCompilerServices,
		StudentModuleRepositoryInterface $studentModuleRepositoryInterface,
		StudentModuleAnswerRepositoryInterface $studentModuleAnswerRepositoryInterface
	){
		$this->module = $moduleRepositoryInterface;
		$this->module_question_template = $moduleQuestionTemplateRepositoryInterface;
		$this->question_template = $questionTemplateRepositoryInterface;
		$this->question_grade_condition = $questionGradeConditionRepositoryInterface;
		$this->question_cache = $questionCacheRepositoryInterface;
		$this->equation_compiler = $equationCompilerServices;
		$this->student_module = $studentModuleRepositoryInterface;
		$this->student_module_answer = $studentModuleAnswerRepositoryInterface;
	}

	//generate questions per dynamic module

	//Requirements --
	//Data Library
	//Question Template
	//

	//get all dynamic modules then per questions
	//generate question per type of questions
	public function generateQuestions($module_id,$sample_view=0){

		//get dynamic modules
		$module = $this->module->getModule($module_id);

		//get max number
		$max_value = $this->question_grade_condition->getGradeId($module->grade_id);

		//TODO: Get Grade and max number required.


		//get module_question_template
		$templates = $this->module_question_template->getTemplateByModule($module_id);

		$question_list = [];

		//loop through each question
		foreach($templates as $template){

			//get question_template_id
			$question_template = $this->question_template->getQuestionTemplate($template->question_template_id);


			//random number from max_value
			$question_template->max_value = $max_value->max_number;

			//TODO:: filter between kind of question template

			//blank,series,word
			switch($question_template->question_form){

				case config('futureed.question_form_word'):
					//generate word question form
					$question = '';
					dd('word');
					break;
				case config('futureed.question_form_series'):
					//generate word question series
					$question=$this->questionFormSeries($question_template);
					break;
				default :
					//generate word question blank
					dd('blank');
					$question = '';
					break;
			}


			array_push($question_list,[
				'question' => $question,
				'template' => $template
			]);

		}

		//add questions to question cache table
		$this->addQuestions($question_list);

		return 1;
	}

	public function addQuestions($question_list=[]){

		//module_question_template_id
		//question_template_id
		//question_text
		//question_values

		foreach($question_list as $list){

			//check if question template already exist

			//delete if exist else add
			$module_question = $this->question_cache->getModuleTemplate($list['template']->id,$list['template']->question_template_id);

			//delete existing module question
			if(!empty($module_question)){

				$this->question_cache->deleteQuestionCache($module_question->id);

			}

			//add new module questions
			$question_cached = $this->question_cache->addQuestionCache([
				'module_question_template_id' => $list['template']->id,
				'question_template_id' => $list['template']->question_template_id,
				'question_text' => $list['question'][0],
				'question_values' => $list['question'][1],
			]);

			$answer = $this->equation_compiler->solve($question_cached->id);

			//add answer to cache.
			$this->question_cache->updateQuestionCache($question_cached->id,[
				'answer' => $answer
			]);
		}

		return true;
	}

	//question forms

	public function questionFormWord($question_template){

	}

	//series
	public function questionFormSeries($question_template){

		//generate questions with values

		//parse through equation and count how many variables

//		dd($question_template->toArray());
		$matches = $this->countEquationVariables($question_template->question_equation);

		//TODO separate random numbers dependent on Operations
		$values = [];

		switch ($question_template->operation){
			case config('futureed.addition'):
				foreach($matches as $match){
					$values[$match] = rand(1,$question_template->max_value);
				}
				break;
			case config('futureed.subtraction'):
				//get 40% of minimum for minuend
				$minuend = rand(round($question_template->max_value * 0.4),$question_template->max_value);
				//get minuend-1 maximum value
				$subtrahend = rand($minuend - 1,round($question_template->max_value * 0.4));
				$values[$matches[0]] = $minuend;
				$values[$matches[1]] = $subtrahend;
				break;
			case config('futureed.multiplication'):
				foreach($matches as $match){
					$values[$match] = rand(1,$question_template->max_value);
				}
				break;
			case config('futureed.division'):
				break;
			default:
				break;
		}

		//replace question template into
		$final_question = $question_template->question_template_format;

		//generate steps
		if($question_template->operation == config('futureed.addition')
			|| $question_template->operation == config('futureed.subtraction')){

			$steps = 0;
			foreach($values as $k => $value){

				$final_question = str_replace($k,$value,$final_question);
				$steps = $this->countStepStrLen($value,$steps);
			}
		}elseif($question_template->operation == config('futureed.multiplication')){

			$steps = $this->countStepMultiply($values);

		}else {

			$steps = 1;
		}

		//determine how many step need to solve the questions.

		//add steps to final questions

		// out final question and values used/replace on the variables.
		return [
			$final_question,
			json_encode([
				'values' => $values,
				'steps' => $steps
			])
		];
	}

	public function countStepStrLen($value,$steps){

		return (strlen($value) > $steps) ? strlen($value) : $steps;
	}

	public function countStepMultiply($value){

		return ($value["{num2}"] > 0 ) ? strlen($value["{num2}"]) : 1;
	}

	public function questionFormBlank($question_template){

	}

	public function countEquationVariables($equation_template){

		$variable_pattern = '/{num.}/';

		preg_match_all($variable_pattern,$equation_template,$matches);

		return $matches[0];

	}

	public function dynamicNextQuestion($student_module_id,$module_id,$student_answer){

		//check student module
		$student_module = $this->student_module->getStudentModule($student_module_id);

		//get list of questions from cache.
		$module_question_template = $this->module_question_template->getTemplateByModule($module_id);

		//check last student module answer
		$student_module_answer = $this->student_module_answer->getStudentModuleAnswer($student_module_id,$module_id);
			//get last question answers
				// get next question from the last answered question

		$next_question = 0;
		$flag = 0;
		foreach($module_question_template as $template){

			foreach($student_module_answer as $answer){

				if($template->questionCache->id == $answer->question->id && $flag == 0){
					$flag = 1;
				}
			}

			if($flag == 0){
				return $template->questionCache->id;
			}

			$flag = 0;
		}
		return $next_question;
		//output >1 next question; 0=< completed
	}


	/**
	 * @param $question_strings
	 * @param array $attributes
	 * @internal param $form
	 */
	public function 	generatePreviewQuestion($question_strings, $attributes = []){

		//replace questions variables with object
		//set min and max values
		//max value 1-999

		//check what type of question

		//initialize attributes
		$question_template = new \stdClass();
		$question_template->question_equation = $question_strings;
		$question_template->operation = $attributes['operation'];
		$question_template->max_value = 999;
		$question_template->question_template_format = $question_strings;



		//blank,series,word
		switch($attributes['question_form']){

			case config('futureed.question_form_word'):
				//generate word question form
				$question = '';
				dd('word');
				break;
			case config('futureed.question_form_series'):
				//generate word question series
				$question = $this->questionFormSeries($question_template);
				break;
			default :
				//generate word question blank
				dd('blank');
				$question = '';
				break;
		}

		return $question[0];
	}

}