<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class StudentPointRequest extends ApiRequest {

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
				return[
					'student_id' => 'required|integer',
					'points_earned' => 'required|integer',
					'module_id' => 'required|integer'

				];
				break;

			case 'PUT':
				return [
					'event_id' => 'required|integer',
					'points_earned' => 'required|integer',
					'description' => 'string'

				];
				break;

		}
	}

	public function messages()
	{
		return [
			'event_id.integer' => 'Event is invalid.',
			'points_earned.integer' => 'Points must be a number.',
			'student_id.required' => 'Student is required.',
			'student_id.integer' => 'Student is invalid.',

		];
	}

}
