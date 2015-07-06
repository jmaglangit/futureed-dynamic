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
				
		switch($this->method) {
			case 'PUT':
				return [
					'name' => 'required',
					'status' => 'required|in:Enabled,Disabled',
					'country_id' => 'required|Integer'
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
			'integer' => 'The :attribute must be a number.' 
		];
	}
}