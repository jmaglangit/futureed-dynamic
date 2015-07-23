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
			'badge_id.required' => 'Badge name is required.',
			'badge_id.integer' => 'Badge name is invalid.',
		];
	}

}
