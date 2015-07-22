<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class StudentModuleRequest extends ApiRequest {

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

			case 'PUT':

				return [
					'last_viewed_content_id' => 'required|integer'
				];
		}
	}

	public function messages()
	{

		return [
			'last_viewed_content_id.required' => 'Content is required.',
			'last_viewed_content_id.integer' => 'Content is invalid.',

		];
	}

}
