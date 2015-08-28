<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class ClientRegisterRequest extends ApiRequest {

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
					'username' => 'required|min:8|max:32|alpha_num',
					'password' => 'required|min:8|max:32',
					'callback_uri' =>'required|string|max:128',
					'email' => 'required|email',
					'first_name' => 'required|min:2|regex:'. config('regex.name') .'|max:64',
					'last_name' => 'required|min:2|regex:'. config('regex.name') .'|max:64',
					'client_role' => 'required|in:' . config('futureed.parent').','.config('futureed.principal').','. config('futureed.teacher'),

					'city' => 'required_if:client_role,'.config('futureed.parent').'|max:128|regex:'.config('regex.state_city'),
					'state' => 'required_if:client_role,'.config('futureed.principal').'|max:128|regex:'.config('regex.state_city'),
					'country' => 'string|max:128',
					'country_id' => 'required|numeric|exists:countries,id',
					'zip' => 'max:10|regex:'. config('regex.zip_code'),

					//Parent
					'street_address' => 'required_if:client_role,'. config('futureed.parent').'|string|max:128',

					//Principal
					'contact_name' => 'required_if:client_role,'.config('futureed.principal').'|min:2|regex:'. config('regex.name') .'|max:128',
					'school_name' => 'required_if:client_role,'.config('futureed.principal').'|string|max:128',
					'school_address' => 'required_if:client_role,'.config('futureed.principal').'|String|max:128',
					'school_city' => 'max:128|regex:'.config('regex.state_city'),
					'school_state' => 'required|max:128|regex:'.config('regex.state_city'),
					'school_country_id' => 'required|numeric',
					'school_zip' => 'max:10|regex:'. config('regex.zip_code'),
					'contact_number' => 'required_if:client_role,'.config('futureed.principal').'|max:20|regex:'.config('regex.phone'),
				];

		}
	}

	/**
	 * Modified messages
	 */
	public function messages(){

		return [
			'country_id.required' => config('futureed-error.error_messages.2603'),
			'country_id.numeric' => config('futureed-error.error_messages.2604'),
			'country_id.exists' => config('futureed-error.error_messages.2203'),
			'zip.regex' => config('futureed-error.error_messages.2044'),
			'zip.max' => config('futureed-error.error_messages.2045'),
			'school_country_id.required' => config('futureed-error.error_messages.2603'),
			'school_country_id.numeric' => config('futureed-error.error_messages.2604'),
			'contact_number.regex' => config('futureed-error.error_messages.2115')
		];
	}

}
