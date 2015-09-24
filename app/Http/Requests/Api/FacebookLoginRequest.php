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
							'birth_date' => 'required|date',
							'grade_code' => 'required|exists:grades,code',
							'country_id' => 'required|exists:countries,id',
							'city' => 'required',

							'gender' => 'required_if:user_type,' . config('futureed.student'),
							'client_role' => 'required_if:user_type,' . config('futureed.client')
								.'|in:' . config('futureed.parent')
								.','. config('futureed.teacher')
								.','. config('futureed.principal')
						];
						break;

					case 'api.v1.login.facebook':

						return [
							'facebook_app_id' => 'required|integer
								|exists:users,facebook_app_id,deleted_at,NULL,is_account_activated,0,is_account_locked,0,user_type,'
								. $this->__get('user_type'),
							'user_type' => 'required|in:'. config('futureed.client') . ',' . config('futureed.student')
						];
						break;
				}

		}
	}

}
