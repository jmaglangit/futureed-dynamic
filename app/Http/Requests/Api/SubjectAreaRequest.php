<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class SubjectAreaRequest extends ApiRequest {
	
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
				
		switch($this->method()) {
			case 'PUT':
				return [
					'subject_id' => 'required|integer|exists:subjects,id',
					'name' => 'required',
					'status' => 'required|in:Enabled,Disabled'
				];
				break;
			case 'POST':
			default:
				return [
					'subject_id' => 'required|integer|exists:subjects,id',
					'code' => 'required|integer|unique:subject_areas,code,NULL,id,deleted_at,NULL',
					'name' => 'required|regex:'. config('regex.name'),
					'status' => 'required|in:Enabled,Disabled'
				];				
	        	break;
		}
		
	}
	
	/**
	 * Get the validation rules custom messages that apply to the request.
	 *
	 * @return array
	 */
	public function messages() {
		return [
			'integer' => trans('errors.1013'),
			'subject_id.required' => trans('errors.1003',['attribute' => trans('errors.2155')]),
			'subject_id.integer' => trans('errors.1003',['attribute' => trans('errors.2155')]),
			'subject_id.exists' => trans('errors.1004',['attribute' => trans('errors.2155')]),
			'code.required' => trans('validation.required',['attribute' => trans('errors.2215')]),
			'code.integer' => trans('validation.numeric',['attribute' => trans('errors.2215')]),
			'name.required' => trans('validation.numeric',['attribute' => trans('errors.2156')]),

		];
	}
}