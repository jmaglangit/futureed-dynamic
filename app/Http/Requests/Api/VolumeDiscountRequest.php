<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class VolumeDiscountRequest extends ApiRequest {
	
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
    	switch($this->method){
	        case 'POST':
	            return ['min_seats'     => 'required|numeric|min:1|max:30000|unique:volume_discounts,min_seats',
            			'percentage'    => 'required|numeric|min:1|max:100',
            			'status'        => 'required|in:Enabled,Disabled'];
	        break;
	        case 'PATCH':
	            return ['min_seats'     => 'required|numeric|min:1|max:30000|unique:volume_discounts,min_seats,'.$this->min_seats.',min_seats',
            			'percentage'    => 'required|numeric|min:1|max:100',
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
			'numeric' => 'The :attribute must be a number.',
			'unique'  => 'Bulk Number already exists.' 
		];
	}
}