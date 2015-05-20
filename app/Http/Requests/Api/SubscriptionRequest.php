<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class SubscriptionRequest extends ApiRequest {
	
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
            'name'          => 'required',
			'price'         => 'required|numeric|min:0.01|max:999999.99',
			'description'   => 'required',
			'status'        => 'required|in:Enabled,Disabled'
        ];
	}
	
	/**
	 * Get the validation rules custom messages that apply to the request.
	 *
	 * @return array
	 */
	public function messages() {
		return [
			'numeric' => 'The :attribute must be a number.' 
		];
	}
}