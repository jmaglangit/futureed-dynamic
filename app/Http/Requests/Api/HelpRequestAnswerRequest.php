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
            'student_id.required' =>'Student is required.',
            'help_request_id.required' =>'Help request is required.',
            'student_id.integer' =>'Student must be a number.',
            'help_request_id.integer' =>'Help request must be a number.',
            'content.required' => 'The answer field is required.',
            'content.string' => 'The answer field is invalid.'
		];
	}

}
