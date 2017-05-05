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
	public function generateQuestions($module_id){

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

		$matches = $this->countEquationVariables($question_template->question_equation);

		$values = [];
		foreach($matches as $match){

			$values[$match] = rand(1,$question_template->max_value);
		}


		//replace question template into
		$final_question = $question_template->question_template_format;

		$steps = 0;
		foreach($values as $k => $value){

			$final_question = str_replace($k,$value,$final_question);

				$steps = (strlen($value) > $steps) ? strlen($value) : $steps;

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

	public function questionFormBlank($question_template){

	}

	public function countEquationVariables($equation_template){

		$variable_pattern = '/{num.}/';

		preg_match_all($variable_pattern,$equation_template,$matches);

		return $matches[0];

	}

	public function dynamicNextQuestion($student_module_id,$module_id,$student_answer){

//		$data['student_module_id'],
//				$data['module_id'],
//				$student_answer

		//check student module
		$student_module = $this->student_module->getStudentModule($student_module_id);
//		dd($student_module->toArray());

		//get list of questions from cache.
		$module_question_template = $this->module_question_template->getTemplateByModule($module_id);

//		dd($module_question_template->toArray());

		//check last student module answer
		$student_module_answer = $this->student_module_answer->getStudentModuleAnswer($student_module_id,$module_id);
//		dd($student_module_answer->toArray());
			//get last question answers
				// get next question from the last answered question

		$next_question = 0;
		$flag = 0;
		$collection = [];
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


}