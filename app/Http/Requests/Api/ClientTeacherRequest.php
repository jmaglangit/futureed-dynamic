<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class ClientTeacherRequest extends ApiRequest
{

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
		switch ($this->method) {
			case 'PUT':
				$client = config('futureed.client');
				return [
					'first_name' => 'required|regex:'. config('regex.name') ,
					'last_name' => 'required|regex:'. config('regex.name'),
					'street_address' => 'string',
					'city' => 'string',
					'state' => 'string',
					'zip' => 'max:10|regex:'.config('regex.zip_code'),
					'country_id' => 'integer'
				];
				break;
			case 'POST':
			default:
				$client = config('futureed.client');
				return [
					'username' => "required|alpha_num|string|min:8|max:32|unique:users,username,NULL,id,user_type,$client,deleted_at,NULL",
					'email' => "required|email|unique:users,email,NULL,id,user_type,$client,deleted_at,NULL",

					'first_name' => 'required|regex:'. config('regex.name'),
					'last_name' => 'required|regex:'. config('regex.name') ,
					'current_user' => 'required|numeric',
					'callback_uri' => 'required|string',
					'country_id' => 'integer'
				];
				break;
		}
	}

	/**
	 * Get the validation rules custom messages that apply to the request.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'numeric' => 'The :attribute must be a number.',
			'unique' => 'Teacher already exists.',
			'country_id.integer' => 'Country is invalid.',
		];
	}
}