<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class InvoiceDetailRequest extends ApiRequest {
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
        switch($this->method()) {
            case 'POST':
                return [
                    'id' => 'required',
                    'payment_status' => 'required|in:Pending,Paid,Cancelled',
                ];
        }
    }

	/**
	 * Get the validation rules custom messages that apply to the request.
	 *
	 * @return array
	 */
	public function messages() {
		return [
			'id.required' => trans('errors.1003',['attribute' => trans('errors.2198')]),
		];
	}
}