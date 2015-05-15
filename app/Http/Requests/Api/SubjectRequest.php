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
        return [
            'code' => 'required|integer',
			'name' => 'required',
			'status' => 'required|in:Enabled,Disabled'
        ];
	}
	
	public function messages() {
		return [
			'integer' => 'The :attribute must be a number.' 
		];
	}
}