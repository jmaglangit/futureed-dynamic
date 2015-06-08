<?php namespace FutureEd\Http\Requests\Api;


class ClientTeacherRegistrationRequest extends ApiRequest {

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
			case 'GET':

				//For registration token validation
				return [
					'registration_token' => "required:exists:users,registration_token,deleted_at,null",

				];
				break;

			case 'POST':
			default:
				return [
					'email' => 'required',
					'username' => 'required',
					'password' => 'required',
					'first_name' => 'required',
					'last_name' => 'required',
					'role' => 'required',
					'address' => 'required',
					'city' => 'required',
					''
				];

		}
	}

}
