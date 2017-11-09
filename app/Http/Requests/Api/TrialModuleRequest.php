<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Services\ErrorMessageServices;
use League\Csv\Reader;

class TrialModuleRequest extends ApiRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		if($this->method() === 'POST'){
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$question_type=$this->request->get('question_type');
		$question_answer = $this->request->get('answer');
		$fib_length = $this->request->get('fib_length');

		$rules = [];

		switch($question_type) {

			case config('futureed.question_type_fill_in_the_blank'):
				if(empty($question_answer)){
					return [
						'answer' => 'required'
					];
				} else {
					foreach($fib_length as $key => $answer) {
						$rules['answer.'.$key] = 'required';
					}
				}
				return $rules;
				break;

			case config('futureed.question_type_graph'):
				$has_answer = [];

				foreach($question_answer as $answer) {
					if($answer == 0) {
						$has_answer[] = false;
					} else {
						$has_answer[] = true;
					}
				}

				if(!(in_array(true, $has_answer))) {
					$rules = [
						'answer.0' => 'numeric|min:1'
					];
				}

				return $rules;
				break;

			case config('futureed.question_type_quad'):
				return[
					'has_plotted' => 'numeric|min:1'
				];
				break;

			default:
				return [
					'answer' => 'required'
				];
				break;
		}
	}

	public function messages()
	{
		$question_type = $this->request->get('question_type');
		$question_answer = $this->request->get('answer');
		$fib_length = $this->request->get('fib_length');

		$message = [];

		switch($question_type) {

			case config('futureed.question_type_fill_in_the_blank'):
				if(empty($question_answer)){
					$message['answer.required'] = trans('errors.'.ErrorMessageServices::TRIAL_MODULE_MULTIPLE_ANSWERS_REQUIRED);
				} else {
					foreach ($fib_length as $key => $answer) {
						$message['answer.' . $key . '.required'] = 'Answer ' . ($key + 1) . ' is required';
					}
				}
				return $message;
				break;

			case config('futureed.question_type_graph'):
				return [
					'answer.0.min' => trans('errors.'.ErrorMessageServices::TRIAL_MODULE_DRAG_DROP_REQUIRED)
				];
				break;

			case config('futureed.question_type_quad'):
				return[
					'has_plotted.min' => trans('errors.'.ErrorMessageServices::TRIAL_MODULE_QUAD_PLOTTING_REQUIRED)
				];
				break;

			default:
				return [
					'answer.required' => trans('errors.'.ErrorMessageServices::TRIAL_MODULE_ANSWER_IS_REQUIRED)
				];
				break;

		}
	}

}
