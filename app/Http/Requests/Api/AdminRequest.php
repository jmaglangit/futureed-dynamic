<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class AdminRequest extends ApiRequest {

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
				/*
return [
					'subject_id' => 'required|integer|exists:subjects,id',
					'name' => 'required',
					'status' => 'required|in:Enabled,Disabled'
				];
*/
				break;
			case 'POST':
			default:
				return [
					'username' => 'required|min:8|max:32|alpha_num|unique:users,username,NULL,id,user_type,'.config('futureed.admin'),
					'email' => 'required|email|unique:users,email,NULL,id,user_type,'.config('futureed.admin'),
					'admin_role' => 'required|in:Admin,Super Admin',
					'status' => 'required|in:Enabled,Disabled',
					'first_name' => 'required|regex:/^([a-z\x20])+$/i|max:64',
					'last_name' => 'required|regex:/^([a-z\x20])+$/i|max:64'
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
			/*
'integer' => 'The :attribute must be a number.',
			'subject_id.required' =>'The subject is required.',
			'subject_id.integer' =>'The subject is required.',
			'subject_id.in' =>'The subject is invalid.'
*/
		];
	}
}