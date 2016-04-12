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

				switch($this->route()->getName()){

					case 'api.v1.registration.facebook':

						return [

							'facebook_app_id'   => 'required|string|unique:users,facebook_app_id,NULL,id,deleted_at,NULL,user_type,'.$this->__get('user_type'),
							'username'          => 'required|min:8|max:32|alpha_num|unique:users,username,NULL,id,deleted_at,NULL,user_type,'.$this->__get('user_type'),
							'email'             => 'required|email|unique:users,email,NULL,id,deleted_at,NULL,user_type,'.$this->__get('user_type'),
							'first_name'        => 'required|min:2|max:64|regex:'. config('regex.name'),
							'last_name'         => 'required|min:2|max:64|regex:'. config('regex.name'),
							'country_id'        => 'exists:countries,id',
							'user_type'         => 'required|in:'. config('futureed.client') . ',' . config('futureed.student'),


							//Student
							'birth_date'        => 'required_if:user_type,' . config('futureed.student').'|date|before:-14 year',
							'grade_code'        => 'exists:grades,code',
							'gender'            => 'required_if:user_type,' . config('futureed.student').'|in:'.config('futureed.gender.male').','.config('futureed.gender.female'),

							//Client
							'client_role'       => 'required_if:user_type,' . config('futureed.client')
								.'|in:' . config('futureed.parent')
								.','. config('futureed.principal'),
							'zip'               => 'max:10|regex:'. config('regex.zip_code'),

							//Principal
							'state'             => 'max:128|regex:'.config('regex.state_city'),
							'contact_name'      => 'required_if:client_role,'.config('futureed.principal').'|min:2|regex:'. config('regex.name') .'|max:128',
							'school_name'       => 'required_if:client_role,'.config('futureed.principal').'|string|max:128',
							'school_address'    => 'required_if:client_role,'.config('futureed.principal').'|String|max:128',
							'school_city'       => 'max:128|regex:'.config('regex.state_city'),
							'school_state'      => 'required_if:client_role,'.config('futureed.principal').'|max:128|regex:'.config('regex.state_city'),
							'school_country_id' => 'required_if:client_role,'.config('futureed.principal').'|numeric',
							'school_zip'        => 'max:10|regex:'. config('regex.zip_code'),
							'contact_number'    => 'required_if:client_role,'.config('futureed.principal').'|max:20|regex:'.config('regex.phone'),

						];
						break;

					case 'api.v1.login.facebook':

						return [
							'facebook_app_id' => 'required|string
								|exists:users,facebook_app_id,deleted_at,NULL,is_account_activated,1,is_account_locked,0,user_type,'
								. $this->__get('user_type'),
							'user_type' => 'required|in:'. config('futureed.client') . ',' . config('futureed.student')
						];
						break;
				}

		}
	}

	/**
	 * Modified messages
	 */
	public function messages(){

		return [
			'country_id.required'           => trans('validation.required',['attribute' => trans('errors.2154')]),
			'country_id.numeric'            => trans('validation.numeric',['attribute' => trans('errors.2154')]),
			'country_id.exists'             => trans('errors.1004',['attribute' => trans('errors.2186')]),
			'zip.regex'                     => trans('errors.1008',['attribute' => trans('errors.2187')]),
			'zip.max'                       => trans('errors.1009',['attribute' => trans('errors.2187')]),
			'school_country_id.required'    => trans('validation.required',['attribute' => trans('errors.2154')]),
			'school_country_id.numeric'     => trans('validation.numeric',['attribute' => trans('errors.2154')]),
			'contact_number.regex'          => trans('errors.1010',['attribute' => trans('errors.2188')]),
			'birth_date.before'             => trans('errors.2028'),
		];
	}

}
