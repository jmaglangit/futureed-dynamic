<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class ClassroomRequest extends ApiRequest {

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
                switch( $this->route()->getName() ){
                    case 'classroom.update.invoice-classroom':
                        return [
                            'name' => 'required|regex:'. config('regex.name'),
                            'grade_id' => 'required|integer',
                            'seats_total' => 'required|numeric',
                            'client_id' => 'required|integer',
                        ];
                        break;
                    default:
                        return ['name' => 'required'];
                }
                break;
            case 'PATCH':
                break;

            case 'POST':
            default:
                return [
                    'order_no' => 'required',
                    'name' => 'required|regex:'. config('regex.name'),
                    'grade_id' => 'required|integer',
                    'client_id' => 'required|integer',
                    'seats_taken' => 'required|numeric',
                    'seats_total' => 'required|numeric',
                    'status' => 'required|in:Enabled,Disabled'
                ];
                break;
        }
    }

    /**
     * Get the validation rules custom messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'grade_id.required' => 'grade field is required.',
            'client_id.required' => 'client field is required.'
        ];
    }

}
