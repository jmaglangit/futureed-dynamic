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

			case 'PUT':

				return [
					'content' => 'required|string',
					'status' => 'required|in:Enabled,Disabled',
				];
				break;
		}
	}

	public function messages(){

		return [

		];
	}

}
