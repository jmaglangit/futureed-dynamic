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
					'description' => 'string'

				];
				break;

		}
	}

	public function messages()
	{
		return [
			'event_id.integer' => trans('errors.1004',['attribute' => trans('errors.2212')]),
			'points_earned.integer' => trans('errors.1013',['attribute' => trans('errors.2213')]),
			'student_id.required' => trans('errors.1003',['attribute' => trans('errors.2192')]),
			'student_id.integer' => trans('errors.1004',['attribute' => trans('errors.2192')]),
			'module_id.required' => trans('errors.1003',['attribute' => trans('errors.2161')]),
			'module_id.integer' => trans('errors.1004',['attribute' => trans('errors.2161')]),

		];
	}

}
