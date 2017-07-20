<?php

namespace FutureEd\Services;


class QuestionTemplateServices {

	// protected $question_template;


	// public function __construct(

	// ){

	// }

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

			default:
				break;
		}

	}
}
