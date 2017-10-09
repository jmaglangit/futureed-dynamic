<?php

namespace FutureEd\Services;


use FutureEd\Models\Repository\QuestionTemplateOperation\QuestionTemplateOperationRepositoryInterface;

class QuestionTemplateServices {

	protected $question_template_operation;

	/**
	 * QuestionTemplateServices constructor.
	 * @param QuestionTemplateOperationRepositoryInterface $questionTemplateOperationRepositoryInterface
	 */
	public function __construct(
		QuestionTemplateOperationRepositoryInterface $questionTemplateOperationRepositoryInterface
	) {
		$this->question_template_operation = $questionTemplateOperationRepositoryInterface;

	}

	/**
	 * @param $question_template
	 * @return array|bool
	 */
	public function checkOperationVariables($question_template){
		$operation_var = $question_template['question_template_format'];

		// search variable in the template text area
		$template_first_var = $this->checkTempVariable($operation_var, config('futureed.template_variables1'));
		$template_second_var = $this->checkTempVariable($operation_var, config('futureed.template_variables2'));
		$template_var = $this->checkTempVariable($operation_var, $question_template['operation']);

		//check variables
		if(($template_first_var !== false && $template_second_var !== false) || $template_var !== false){
			return true;
		}elseif($template_first_var === false && $template_second_var === false && $template_var === false){
			return [
				'message' => trans('errors.2606')
			];

		}else{
			return [
				'message' => trans('errors.2605')
			];

		}

	}

	/**
	 * Check question template text if variable/s is found.
	 * @param $question_template_text
	 * @param $find_string
	 * @return bool
	 */
	public function checkTempVariable($question_template_text, $find_string) {
		if(!is_array($find_string)) $find_string = array($find_string);

		foreach($find_string as $string) {
			$mod_string = '{'. $string .'}';

			if(strpos($question_template_text, $mod_string) !== false)
				return true; //will return true if variable is found
		}

		return false;
	}

}
