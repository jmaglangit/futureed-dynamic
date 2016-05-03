<?php namespace FutureEd\Http\Requests\Api;



class HelpRequestAnswerRequest extends ApiRequest {

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
                    'student_id' => 'required|integer',
                    'content' => 'required|string|max:128',
                    'help_request_id' => 'required|integer'
                ];
                break;
			case 'PUT':

				return [
					'content' => 'required|string|max:128',
					'status' => 'required|in:Enabled,Disabled',
				];
				break;
		}
	}

	public function messages(){

		return [
            'student_id.required' => trans('errors.1003',['attribute' => trans('errors.2192')]),
            'help_request_id.required' => trans('errors.1003',['attribute' => trans('errors.2193')]),
            'student_id.integer' =>trans('errors.1003',['attribute' => trans('errors.2192')]),
            'help_request_id.integer' => trans('errors.1013',['attribute' => trans('errors.2193')]),
            'content.required' => trans('validation.required',['attribute' => trans('errors.2171')]),
            'content.string' => trans('errors.1004',['attribute' => trans('errors.2171')]),
		];
	}

}
