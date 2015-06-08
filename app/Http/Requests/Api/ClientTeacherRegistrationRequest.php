<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class ClientTeacherRegistrationRequest extends Request {

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

			case 'POST':
			default:
				return [
					'email' => 'required',
					'username' => 'required',
					'password' => 'required',
					'first_name' => 'required',
					'last_name' => 'required',
					'role' => 'required',
					''
				];

		}
	}

}
