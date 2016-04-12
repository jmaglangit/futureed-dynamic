<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class ClientDiscountRequest extends ApiRequest {
	
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
	            return ['client_id'     => 'required|numeric|unique:client_discounts,client_id,NULL,id,deleted_at,NULL',
            			'percentage'    => 'required|numeric|min:1.00|max:100.00',
            			'status'        => 'required|in:Enabled,Disabled'];
	        break;
	        case 'PUT':
	            return ['client_id'     => 'required|numeric|unique:client_discounts,client_id,'.$this->client_id.',client_id,deleted_at,NULL',
            			'percentage'    => 'required|numeric|min:1.00|max:100.00',
            			'status'        => 'required|in:Enabled,Disabled'];
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
			'unique' => trans('errors.1007',['attribute' => trans('errors.2184')]),
			'client_id.required' => trans('validation.required',['attribute' => trans('errors.2185')]),
		];
	}
}