<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class GradeRequest extends ApiRequest {
	
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
					'country_id' => 'required|Integer',
					'age_group_id' => 'required|exists:age_groups,id,deleted_at,NULL'
				];
				break;
			case 'POST':
			default:
				return [
					'code' => 'required|Integer|Unique:grades',
					'name' => 'required|regex:' . config('regex.name_numeric'),
					'age_group_id' => 'required|exists:age_groups,id,deleted_at,NULL',
					'status' => 'required|in:Enabled,Disabled',
					'country_id' => 'required|Integer'
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
			'code.required' => trans('validation.required',['attribute' => trans('errors.2190')]),
			'code.integer' => trans('validation.numeric',['attribute' => trans('errors.2190')]),
			'name.required' => trans('validation.required',['attribute' => trans('errors.2153')]),
			'age_group_id.required' => trans('validation.required',['attribute' => trans('errors.2191')]),
			'country_id.required' => trans('validation.required',['attribute' => trans('errors.2154')]),
		];
	}
}