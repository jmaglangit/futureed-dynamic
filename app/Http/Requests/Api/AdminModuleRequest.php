<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class AdminModuleRequest extends ApiRequest {

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
					'subject_id' => 'required|integer',
					'subject_area_id' => 'required|integer',
					'name' => 'required|string',
					'code' => 'required|integer',
					'description' => 'required|string',
					'common_core_area' => 'required|string',
					'common_core_url' => 'required|string',
					'status' => 'required|alpha|in:Enabled,Disabled',
					'points_to_unlock' => 'required|integer',
					'points_to_finish' => 'required|integer'

				];

			case 'PUT':

				return [
					'subject_id' => 'required|integer',
					'subject_area_id' => 'required|integer',
					'name' => 'required|string',
					'description' => 'required|string',
					'common_core_area' => 'required|string',
					'common_core_url' => 'required|string',
					'status' => 'required|alpha|in:Enabled,Disabled',
					'points_to_unlock' => 'required|integer',
					'points_to_finish' => 'required|integer'

				];
		}
	}

	/**
	 * Get the validation rules custom messages that apply to the request.
	 *
	 * @return array
	 */
	public function messages() {
		return [
			'subject_id.required' => 'Subject is required.',
			'subject_id.integer' => 'Subject is invalid.',
			'subject_area_id.required' => 'Area is required.',
			'subject_area_id.integer' => 'Area is invalid.',
			'points_to_unlock.integer' => 'Points to unlock must be a number.',
			'points_to_finish.integer' => 'Points to finish must be a number.',
			'name.required' => 'The module field is required.',

		];
	}

}
