<?php namespace FutureEd\Http\Requests\Api;


use FutureEd\Models\Core\Client;

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
		$teacher_id = $this->__get('id');

		$user = Client::find($teacher_id);

		$client = config('futureed.client');

		$user_id = NULL;

		if($user){

			$user_id = $user->user_id;
		}

		switch($this->method){
			case 'GET':

				//For registration token validation
				return [
					'registration_token' => "required|exists:users,registration_token,deleted_at,NULL",

				];
				break;

			case 'PUT':

				//update teacher on registration
				return [

					'email' => 'required|email',
					'username' => "required|min:8|max:32|alpha_num|unique:users,username,$user_id,id,user_type,$client,deleted_at,NULL",
					'password' => 'required|custom_password',
					'first_name' => 'required|regex:/^([a-z\x20])+$/i|max:64',
					'last_name' => 'required|regex:/^([a-z\x20])+$/i|max:64',
					'street_address' => 'required|string',
					'city' => 'required|string',
					'state' => 'required|string',
					'country' => 'exists:countries,name',
					'country_id' => 'required|exists:countries,id',
					'callback_uri'  => 'required|string',
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

	public function messages(){

		return [
			'custom_password' => config('futureed-error.error_messages.2112')
		];
	}

}
