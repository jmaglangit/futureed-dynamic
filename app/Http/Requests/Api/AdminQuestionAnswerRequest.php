<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class AdminQuestionAnswerRequest extends ApiRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		switch($this->method()) {

			case 'POST':
				return [

					'module_id' => 'required|integer',
					'question_id' => 'required|integer',
					'code' => 'required|integer',
					'answer_text' => 'required|string',
					'image' => 'required|mimes:jpeg,jpg,png|max:2000',
					'correct_answer' => 'required|alpha|in:Yes,No',
					'point_equivalent' => 'required|integer',

				];
				break;
		}
	}


	public function messages()
	{
		return [

			'module_id.required' => 'Module is required.',
			'module_id.integer' => 'Module is invalid.',
			'question_id.required' => 'Question is required.',
			'question_id.integer' => 'Question is invalid.',
			'code.integer' => 'Code must be a number.',
			'point_equivalent.integer' => 'Points Equivalent must be a number.',

		];
	}

}
