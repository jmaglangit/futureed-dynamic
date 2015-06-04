<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class OrderRequest extends ApiRequest {

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
        switch($this->method){

            case 'PUT':

                break;

            case 'PATCH':
                break;

            case 'POST':
            default:
                return [
                    'order_no' => 'required|numeric',
                    'order_date' => 'required|date_format:Ymd',
                    'client_id' => 'required|numeric',
                    'subscription_id' => 'required|numeric',
                    'date_start' => 'required|date_format:Ymd',
                    'date_end' => 'required|date_format:Ymd',
                    'seats_total' => 'required|numeric|between:1,999999',
                    'seats_taken' => 'numeric',
                    'total_amount' => 'required|numeric|between:1,999999.99',
                    'payment_status' => 'required|in:Pending,Paid,Cancelled',
                ];
                break;
        }
	}
}
