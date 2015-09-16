<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class RenewSubscriptionRequest extends ApiRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		switch($this->method()){

			case 'POST':

				return [
					'order_date' => 'required|date_format:Ymd',
					'date_start' => 'required|date_format:Ymd',
					'date_end' => 'required|date_format:Ymd',
					'discount' => 'required|numeric|between:0,999.99',
					'total_amount' => 'required|numeric|between:1,999999.99'

				];

		}
	}



}
