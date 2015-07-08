<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class AdminQuestionRequest extends ApiRequest {

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
		switch($this->method()){

			case 'POST':

				return [

					'images' => 'mimes:jpeg,jpg,png|max:2000',
					'module_id' => 'required|integer',
					'seq_no' => 'required|integer',
					'questions_text' => 'required|string',
					'difficulty' => 'required|integer',
					'status' => 'required|alpha|in:Enabled,Disabled',
					'question_type' => 'required|alpha|in:MC,FIB,O,N',
					'points_earned' => 'required|integer',
					'code' => 'required|integer'
				];
		}
	}


	public function messages()
	{
		return [
			'module_id.required' => 'Module is required.',
			'module_id.integer' => 'Module is invalid.',
			'seq_no.integer' => 'Sequence must be a number.',
			'difficulty.integer' => 'Difficulty must be a number.',
			'points_earned.integer' => 'Points earned must be a number.',
			'code.integer' => 'Code must be a number.'

		];
	}

}
