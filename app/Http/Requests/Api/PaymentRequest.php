<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class PaymentRequest extends ApiRequest {

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
        switch($this->method)
        {
            case 'PUT':

                break;
            case 'PATCH':

                break;
            case 'POST':
            default:
                return [
                    'invoice_id' => 'required|numeric',
                    'quantity' => 'required|numeric',
                    'price' => 'required|numeric'];
        }
    }
}
