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

		//check question template operation variables used
		switch($question_template['operation']){
			case config('futureed.addition'):

				if((strpos($operation_var, '{addends1}') != false) && (strpos($operation_var, '{addends2}') != false)){
					return true;
				}else{
					return [
	 					'message' => trans('errors.2605')
 					];
				}

				break;

			case config('futureed.subtraction'):

				if((strpos($operation_var, '{minuend}') != false) && (strpos($operation_var, '{subtrahend}') != false)){
					return true;
				}else{
					return [
	 					'message' => trans('errors.2605')
 					];				
 				}

				break;

			case config('futureed.multiplication'):

				if((strpos($operation_var, '{multiplicand}') != false) && (strpos($operation_var, '{multiplier}') != false)){

					return true;

				}else{
					return [
	 					'message' => trans('errors.2605')
 					];				
 				}

				break;

			case config('futureed.division'):

				if((strpos($operation_var, '{dividend}') != false) && (strpos($operation_var, '{divisor}') != false)){

					return true;

				}else{
					return [
	 					'message' => trans('errors.2605')
 					];				
 				}

				break;

			case config('futureed.fraction_addition'):

				if((strpos($operation_var, '{fraction_addition}') != false)){

					return true;

				}else{
					return [
						'message' => trans('errors.2606')
					];
				}

				break;

			case config('futureed.fraction_subtraction'):

				if((strpos($operation_var, '{fraction_subtraction}') != false)){

					return true;

				}else{
					return [
						'message' => trans('errors.2606')
					];
				}

				break;

			case config('futureed.fraction_multiplication'):

				if((strpos($operation_var, '{fraction_multiplication}') != false)){

					return true;

				}else{
					return [
						'message' => trans('errors.2606')
					];
				}

				break;

			case config('futureed.fraction_division'):

				if((strpos($operation_var, '{fraction_division}') != false)){

					return true;

				}else{
					return [
						'message' => trans('errors.2606')
					];
				}

				break;

			case config('futureed.fraction_addition_butterfly'):

				if((strpos($operation_var, '{fraction_addition_butterfly}') != false)){

					return true;

				}else{
					return [
						'message' => trans('errors.2606')
					];
				}

				break;

			case config('futureed.fraction_subtraction_butterfly'):

				if((strpos($operation_var, '{fraction_subtraction_butterfly}') != false)){

					return true;

				}else{
					return [
						'message' => trans('errors.2606')
					];
				}

				break;

			case config('futureed.fraction_addition_whole'):

				if((strpos($operation_var, '{fraction_addition_whole}') != false)){

					return true;

				}else{
					return [
						'message' => trans('errors.2606')
					];
				}

				break;

			case config('futureed.fraction_subtraction_whole'):

				if((strpos($operation_var, '{fraction_subtraction_whole}') != false)){

					return true;

				}else{
					return [
						'message' => trans('errors.2606')
					];
				}

				break;

			case config('futureed.integer_identify'):

				if((strpos($operation_var, ' {integer_random_digit}') == false) && (strpos($operation_var, ' {integer_random_number}') == false)){
					return [
						'message' => trans('errors.2605')
					];
				}else{
					return true;
				}

				break;

			default:
				//check db if exists.
				if(!empty($this->question_template_operation->getOperationByData($question_template['operation'])->toArray())){
					return true;
				} else {
					return [
						'message' => trans('errors.2606')
					];
				}
				break;
		}

	}
}
