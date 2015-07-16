<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class StudentEmailRequest extends ApiRequest {

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
		$id = $this->__get('id');
		$user_type = config('futureed.student');
		switch($this->method()){

			case 'PUT':

				return [
						'email' => 'required|email',
						'new_email' => "required|email|unique:users,email,$id,id,user_type,$user_type,deleted_at,NULL",
						'password' => 'required',
						'client_id' => 'required|integer',
						'callback_uri' => 'required|string'
				];
		}

	}

	public function messages()
	{

		return [
			'custom_password' => config('futureed-error.error_messages.2112')
		];
	}

}
