<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class InvoiceRequest extends ApiRequest {

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
                return [
                    'order_no' => 'required',
                    'invoice_date' => 'required|date_format:Ymd',
                    'client_id' => 'required|numeric',
                    'client_name' => 'required|regex:'. config('regex.name'),
                    'date_start' => 'required|date_format:Ymd',
                    'date_end' => 'required|date_format:Ymd',
                    'seats_total' => 'required|numeric|between:1,999999',
                    'discount_type' => 'required|in:Volume,Client',
                    'discount_id' => 'required|numeric',
                    'discount' => 'numeric|between:1,999.99',
                    'total_amount' => 'required|numeric|between:1,999999.99',
                    'subscription_id' => 'required|numeric',
                    'payment_status' => 'required|in:Pending,Paid,Cancelled',
                ];
                break;

            case 'PATCH':
                break;

            case 'POST':
                return ['client_id' => 'required|numeric',
                        'client_name' => 'required|regex:'. config('regex.name'),
                        'payment_status' => 'required|in:Pending,Paid,Cancelled'];
            default:

                break;
        }
    }
}
