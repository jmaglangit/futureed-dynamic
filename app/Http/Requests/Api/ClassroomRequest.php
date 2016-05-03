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
        switch($this->method()){

            case 'PUT':
                switch( $this->route()->getName() ){
                    case 'classroom.update.invoice-classroom':
                        return [
                            'name' => 'required|max:128|min:2|regex:'. config('regex.name'),
                            'grade_id' => 'required|integer',
                            'seats_total' => 'required|integer|min:1|max:999999',
                            'client_id' => 'required|integer',
                            'subject_id' => 'required|integer'
                        ];
                        break;
                    default:
                        return ['name' => 'required|max:128|min:2|regex:'. config('regex.name')];
                }
                break;
            case 'PATCH':
                break;

            case 'POST':
            default:
                return [
                    'order_no' => 'required',
                    'name' => 'required|max:128|min:2|regex:'. config('regex.name'),
                    'grade_id' => 'required|integer',
                    'client_id' => 'required|integer',
                    'seats_taken' => 'required|integer|max:999999',
                    'seats_total' => 'required|integer|min:1|max:999999',
                    'status' => 'required|in:Enabled,Disabled',
                    'subject_id' => 'required|integer',
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
			'grade_id.required' => trans('errors.1003',['attribute' => trans('errors.2153')]),
			'grade_id.integer' => trans('validation.numeric',['attribute' => trans('error.2153')]),
			'client_id.required' => trans('errors.1003',['attribute' => trans('errors.')]),
			'client_id.integer' => trans('validation.numeric',['attribute' => trans('errors.2176')]),
			'seats_total.integer' => trans('errors.1004',['attribute' => trans('errors.2177')]),
			'seats_taken.integer' => trans('errors.1004', ['attribute' => trans('errors.2178')]),
			'name.required' => trans('errors.1003',['attribute' => trans('errors.2179')]),
			'seats_total.required' =>  trans('errors.1003',['attribute' => trans('errors.2177')]),
			'name.regex' => trans('validation.regex',['attribute' => trans('errors.2179')]),
			'name.min' => trans('errors.2180'),
			'name.max' => trans('errors.2181'),
			'subject_id.required' => trans('errors.1003',['attribute' => trans('errors.2155')]),
			'subject_id.integer' => trans('validation.numeric',['attribute' => trans('errors.2155')]),
        ];
    }

}
