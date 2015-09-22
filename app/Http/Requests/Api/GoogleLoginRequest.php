<?php namespace FutureEd\Http\Requests\Api;

class GoogleLoginRequest extends ApiRequest {

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

			case 'POST' :

				//Added checking if

				switch($this->route()->getName()){

					case 'api.v1.registration.google':

						return [
							'google_app_id' => 'required|string
								|unique:users,facebook_app_id,NULL,id,user_type,' . $this->__get('user_type'),
							'email' => 'required|email|unique:users,email,NULL,id,user_type,'.$this->__get('user_type'),
							'user_type' => 'required|in:'. config('futureed.client') . ',' . config('futureed.student'),
							'first_name' => 'required',
							'last_name' => 'required',
							'birth_date' => 'required|date',

							'gender' => 'required_if:user_type,' . config('futureed.student'),
							'client_role' => 'required_if:user_type,' . config('futureed.client')
						];
						break;
				}

		}
	}

}
