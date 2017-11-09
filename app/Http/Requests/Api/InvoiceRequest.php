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
        switch($this->method()){

            case 'PUT':
                return [
                    'order_no' => 'required',
                    'invoice_date' => 'required|date_format:Ymd',
                    'client_id' => 'required|integer',
                    'client_name' => 'required|regex:'. config('regex.name'),
                    'date_start' => 'required|date_format:Ymd',
                    'date_end' => 'required|date_format:Ymd',
                    'seats_total' => 'required|numeric|between:1,999999',
                    'discount_type' => 'in:Volume,Client',
                    'discount_id' => 'integer',
                    'discount' => 'numeric|between:0,999.99',
                    'total_amount' => 'required|numeric|between:1,999999.99',
                    'subscription_id' => 'required|integer',
                    'payment_status' => 'required|in:Pending,Paid,Cancelled',
                    'subject_id' => 'required|exists:subjects,id,deleted_at,NULL'
                ];
                break;

            case 'PATCH':
                break;

            case 'POST':
                return ['client_id' => 'required|integer',
                    'client_name' => 'required|regex:'. config('regex.name'),
                    'order_no' => 'required',
                    'payment_status' => 'required|in:Pending,Paid,Cancelled'];
            default:

                break;
        }
    }

    public function messages()
    {
        return [
            'client_id.required' => trans('errors.1003',['attribute' => trans('errors.2176')]),
            'client_id.integer' => trans('errors.1013',['attribute' => trans('errors.2176')]),
            'subscription_id.required' => trans('errors.1003',['attribute' => trans('errors.2199')]),
            'subscription_id.integer' => trans('errors.1013',['attribute' => trans('errors.2199')]),
            'discount_id.integer' => trans('errors.1013',['attribute' => trans('errors.2203')]),
        ];
    }
}
