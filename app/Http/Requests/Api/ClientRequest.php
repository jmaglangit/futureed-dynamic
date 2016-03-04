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
				'id' => 'required|numeric',
				'username' => 'required|min:8|max:32|alpha_num',
				'email' => 'required|email',
				'first_name' => 'required|min:2|regex:'. config('regex.name') .'|max:64',
				'last_name' => 'required|min:2|regex:'. config('regex.name') .'|max:64',
				'street_address' => 'string|max:128',
				'city' => 'max:128|regex:/^[-\pL\s]+$/u',
				'country' => 'string|max:128',
				'country_id' => 'numeric',
				'state' => 'max:128|regex:/^[-\pL\s]+$/u',
				'zip' => 'max:10|regex:'. config('regex.zip_code')
		];

		$validations = [];
		$role =  $this->input('client_role');
		switch($this->method())
		{
			case 'PUT':
				if(strtolower($role) == 'principal')
				{
					$validations = [
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
		}
		return (array_merge($default_validations, $validations));
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
			'school_contact_number.regex' => config('futureed-error.error_messages.2115')
		];
	}

}
