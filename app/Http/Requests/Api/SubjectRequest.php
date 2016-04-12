<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class SubjectRequest extends ApiRequest {
	
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
					'name' => 'required',
					'status' => 'required|in:Enabled,Disabled',
					'description' => 'string|max:256',
				];
				break;
			case 'POST':
			default:
				return [
					'code' => 'required|numeric|digits_between:1,19|unique:subjects,code,NULL,id,deleted_at,NULL',
					'name' => 'required|regex:'. config('regex.name'),
					'status' => 'required|in:Enabled,Disabled',
					'description' => 'string|max:256',
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
			'name.required' => trans('validation.required',['attribute' => trans('errors.2155')]),
			'code.required' => trans('validation.required',['attribute' => trans('errors.2216')]),
			'code.numeric' => trans('validation.numeric',['attribute' => trans('errors.2155')]),
		];
	}
}