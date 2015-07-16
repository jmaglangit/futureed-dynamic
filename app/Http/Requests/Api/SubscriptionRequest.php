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
	    switch($this->method()){
    	    case 'POST':

        	    return [
					'name' => 'required|regex:' . config('regex.name_numeric'),
					'price' => 'required|numeric|min:0.01|max:999999.99',
					'description' => 'required',
					'days' => 'required|integer',
					'status' => 'required|in:Enabled,Disabled'];
    	    break;

    	    case 'PATCH':

                switch($this->route()->getName()){
                    case 'subscription.update.status':
                        return ['status' => 'required|in:Enabled,Disabled'];    
                    break;
                    default:
                    return [
						'name' => 'required|regex:' . config('regex.name_numeric'),
						'price' => 'required|numeric|min:0.01|max:999999.99',
						'description' => 'required',
						'status' => 'required|in:Enabled,Disabled'];
                }

            break;

            case 'PUT':

                return [
                    'name'          => 'required|regex:'. config('regex.name_numeric'),
                    'price'         => 'required|numeric|min:0.01|max:999999.99',
                    'description'   => 'required',
                    'days'          => 'required|integer',
                    'status'        => 'required|in:Enabled,Disabled'
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
			'numeric' => 'The :attribute must be a number.',
			'name.required' => 'The subscription name field is required.',
			'name.regex' => 'The subscription name format is invalid.',
		];
	}
}