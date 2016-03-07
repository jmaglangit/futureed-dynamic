<?php namespace FutureEd\Http\Requests\Api;

use Illuminate\Support\Facades\Input;

class ClientRequest extends ApiRequest {

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
		$default_validations = [
				'username' => 'required|min:8|max:32|alpha_num',
				'email' => 'required|email',
				'first_name' => 'required|min:2|regex:'. config('regex.name') .'|max:64',
				'last_name' => 'required|min:2|regex:'. config('regex.name') .'|max:64',
		];
		$common_validations =[];
		$specific_role_validations = [];
		$role =  $this->input('client_role');
		switch($this->method())
		{
			case 'PUT':
				$common_validations = [
						'id' => 'required|numeric',
						'street_address' => 'string|max:128',
						'city' => 'max:128|regex:/^[-\pL\s]+$/u',
						'country' => 'string|max:128',
						'country_id' => 'numeric',
						'state' => 'max:128|regex:/^[-\pL\s]+$/u',
						'zip' => 'max:10|regex:'. config('regex.zip_code')
				];
				if(strtolower($role) == 'principal')
				{
					$specific_role_validations = [
						'school_code' => 'required|numeric|exists:schools,code,deleted_at,NULL',
						'school_name' => 'required|string|max:128',
						'school_state' => 'required|max:128|regex:/^[-\pL\s]+$/u',
						'school_country' => 'string|max:128',
						'school_country_id' => 'required|numeric',
						'school_street_address' => 'required|string|max:128',
						'school_city' => 'max:128|regex:/^[-\pL\s]+$/u',
						'school_zip' => 'max:10|regex:'.config('regex.zip_code'),
						'school_contact_name' => 'required|min:2|regex:'.config('regex.name') .'|max:128',
						'school_contact_number' => 'required|max:20|regex:'.config('regex.phone')
					];
				}
				break;
			case 'POST':
				$common_validations = [
					'client_role' => 'required|in:Parent,Principal,Teacher',
					'callback_uri' => 'required|string|max:128',
					'status' => 'required|in:Enabled,Disabled',
					'street_address' => 'string|max:128',
					'country' => 'string|max:128',
					'country_id' => 'numeric',
					'zip' => 'max:10|regex:'. config('regex.zip_code')
				];
				if(strtolower($role) == 'teacher')
				{
					$specific_role_validations = [
						'city' => 'max:128|regex:/^[-\pL\s]+$/u',
						'state' => 'max:128|regex:/^[-\pL\s]+$/u',
						'school_name' => 'required|string|max:128',
					];
				}
				if(strtolower($role) == 'principal' || strtolower($role) == 'parent')
				{
					$specific_role_validations = [
						'city' => 'max:128|regex:/^[-\pL\s]+$/u',
						'state' => 'max:128|regex:/^[-\pL\s]+$/u',
					];
					if(strtolower($role) == 'principal')
					{
						$principal_validations = [
							'school_name' => 'required|string|max:128',
							'school_state' => 'required|string|max:128',
							'school_country' => 'string|max:128',
							'school_country_id' => 'required|numeric',
							'school_address' => 'required|string|max:128',
							'school_city' => 'string|max:128',
							'school_zip' => 'max:10|regex:'. config('regex.zip_code'),
							'contact_name' => 'required|min:2|regex:'. config('regex.name') .'|max:128',
							'contact_number' => 'required|max:20'
						];
						$specific_role_validations = array_merge($specific_role_validations, $principal_validations);
					}
				}

				break;
		}
		return (array_merge($default_validations, $specific_role_validations, $common_validations));
	}

	/**
	 * Validation Messages
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'zip.max' => config('futureed-error.error_messages.2045'),
			'zip.regex' => config('futureed-error.error_messages.2044'),

			'school_code.exist' => config('futureed-error.error_messages.2602'),
			'school_code.required' => config('futureed-error.error_messages.2602'),
			'school_code.numeric' => config('futureed-error.error_messages.2602'),
			'school_contact_number.max' => config('futureed-error.error_messages.2046'),
			'school_contact_number.regex' => config('futureed-error.error_messages.2115'),
			'school_country_id.required' => config('futureed-error.error_messages.2603'),
			'school_country_id.numeric' => config('futureed-error.error_messages.2604'),

			'country_id.required' => config('futureed-error.error_messages.2603'),
			'country_id.numeric' => config('futureed-error.error_messages.2604'),

			'contact_number.max' => config('futureed-error.error_messages.2046'),

			'password_image_id.required' => config('futureed-error.error_messages.2138')
		];
	}

}
