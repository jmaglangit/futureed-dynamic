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
				
		switch($this->method) {
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
					'code' => 'required|integer|unique:subject_areas',
					'name' => 'required',
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
			'integer' => 'The :attribute must be a number.',
			'subject_id.required' =>'The subject is required.',
			'subject_id.integer' =>'The subject is required.',
			'subject_id.in' =>'The subject is invalid.'
		];
	}
}