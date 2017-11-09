<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class StudentBadgeRequest extends ApiRequest {

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

			case 'PUT':

				return [

					'badge_id' => 'required|integer',
				];
				break;
		}

	}

	public function messages(){

		return [
			'badge_id.required' => trans('errors.1003',['attribute' => trans('errors.2210')]),
			'badge_id.integer' => trans('errors.1004',['attribute' => trans('errors.2210')]),
		];
	}

}
