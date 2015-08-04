<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class AdminStudentPointRequest extends ApiRequest {

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
	{	switch($this->method()) {

			case 'PUT':
				return [

					'points' => 'required|integer'
				];

		}
	}

	public function messages(){
		return[
			'points.integer' => 'The points must be a number.'
		];
	}

}
