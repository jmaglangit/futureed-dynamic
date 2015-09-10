<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class StudentTipRequest extends ApiRequest {

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
					'title' => 'required|string|max:128',
					'content' => 'required|string|max:128',
					'student_id' => 'required|integer',
				];
				break;
		}
	}

	public function messages()
	{

		return [
			'student_id.required' => 'Student is required.',
			'student_id.integer' => 'Student is invalid.',
			'content.required' => 'The description field is required.',
			'content.string' => 'The description field is invalid.',
		];
	}

}
