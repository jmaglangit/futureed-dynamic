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
		} else return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$question_type=$this->request->get('question_type');
		$question_number = $this->request->get('question_number');
		$reader = Reader::createFromPath(storage_path('seeders/trial-module/csv/') . 'answer.csv');

		$rules = [];

		switch($question_type) {
			case config('futureed.question_type_provide_answer'):
			case config('futureed.question_type_multiple_choice'):
				return [
					'answer' => 'required'
				];
				break;

			case config('futureed.question_type_fill_in_the_blank'):
				$answer = $this->get('answer');

				$answer_list = [];

				foreach($reader as $data){
					if($question_number == $data[0]) {
						$answer_list = array_slice($data, 1);
						break;
					}
				}

				if(count($answer) == 0) {
					$rules = ['answer' => 'required'];
				}
				else if(count($answer) <= count($answer_list))
				{
					foreach($answer_list as $key => $value) {
						if(array_key_exists($key, $answer)){
							if($answer[$key] == null) {
								$rules['answer.'.$key] = 'required';
							}
						} else {
							$rules['answer.'.$key] = 'required';
						}
					}
				}

				return $rules;
				break;

			case config('futureed.question_type_graph'):
				$answers = $this->get('answer');
				$has_answer = [];

				foreach($answers as $answer) {
					if($answer == 0) {
						$has_answer = array_merge($has_answer, [false]);
					} else {
						$has_answer = array($has_answer, [true]);
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
				$answers = $this->get('answer');

				if(empty($answers)) {
					$rules = [
						'answer' => 'required'
					];
				}

				return $rules;
				break;

			default:
				return [];
				break;
		}
	}

	public function messages()
	{
		$question_type = $this->request->get('question_type');
		$question_number = $this->request->get('question_number');
		$reader = Reader::createFromPath(storage_path('seeders/trial-module/csv/') . 'answer.csv');

		$message = [];

		switch($question_type) {
			case config('futureed.question_type_provide_answer'):
			case config('futureed.question_type_multiple_choice'):
			case config('futureed.question_type_quad'):
				return [
					'answer.required' => config('futureed-error.error_messages.'.ErrorMessageServices::TRIAL_MODULE_ANSWER_IS_REQUIRED)
				];
				break;

			case config('futureed.question_type_fill_in_the_blank'):
				$answer = $this->get('answer');

				$answer_list = [];

				foreach($reader as $data){
					if($question_number == $data[0]) {
						$answer_list = array_slice($data, 1);
						break;
					}
				}

				if(count($answer) == 0) {
					$message = [
						'answer.required' => config('futureed-error.error_messages.'.ErrorMessageServices::TRIAL_MODULE_MULTIPLE_ANSWERS_REQUIRED)
					];
				}
				else if(count($answer) <= count($answer_list))
				{
					// check if array index exists on answers(from UI) based from the actual csv answer
					foreach($answer_list as $key => $value) {
						if(array_key_exists($key, $answer)){
							if($answer[$key] == null) {
								$message['answer.'.$key.'.required'] = 'Answer '.($key + 1).' is required';
							}
						} else {
							$message['answer.'.$key.'.required'] = 'Answer '.($key + 1) .' is required';
						}
					}
				}

				return $message;
				break;

			case config('futureed.question_type_graph'):
				$message = [
					'answer.0.min' => config('futureed-error.error_messages.'.ErrorMessageServices::TRIAL_MODULE_DRAG_DROP_REQUIRED)
				];

				return $message;
				break;

			default:
				return [];
				break;

		}
	}

}
