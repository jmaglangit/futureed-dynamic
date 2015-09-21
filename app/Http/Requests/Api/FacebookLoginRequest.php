<?php namespace FutureEd\Http\Requests\Api;

class FacebookLoginRequest extends ApiRequest {

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

					case 'api.v1.registration.facebook':

						return [
							'facebook_app_id' => 'required|integer
								|unique:users,facebook_app_id,NULL,id,user_type,' . $this->__get('user_type'),
							'email' => 'required|email|unique:users,email,NULL,id,user_type,'.$this->__get('user_type'),
							'user_type' => 'required|in:'. config('futureed.client') . ',' . config('futureed.student'),
							'first_name' => 'required',
							'last_name' => 'required',

							'gender' => 'required_if:user_type,' . config('futureed.student'),
							'birth_date' => 'required_if:user_type,' . config('futureed.student'),
							'client_role' => 'required_if:user_type,' . config('futureed.client')
						];
						break;
				}

		}
	}

}
