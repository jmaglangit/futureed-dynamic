<?php namespace FutureEd\Http\Requests\Api;


class StudentControllerRequest extends ApiRequest {

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
		return [
			'first_name' => 'required|min:2|regex:'. config('regex.name') .'|max:64',
			'last_name' => 'required|min:2|regex:'. config('regex.name') .'|max:64',
			'gender' => 'required|alpha|in:male,female',
			'birth_date' => 'required|date_format:Ymd|before:-14 year',
			'grade_code' => 'numeric',
			'country_id' => 'numeric',
			'city' => 'max:128|regex:'.config('regex.state_city'),
			'state' => 'max:128|regex:'.config('regex.state_city'),
			'email' => 'required|email',
			'username' => 'min:8|max:32|alpha_num'
		];
	}

	public function messages()
	{
		return [
			'birth_date.before' => config('futureed-error.error_messages.2117'),
			'grade_code.numeric' => config('futureed-error.error_messages.2023'),
			'country_id.numeric' => config('futureed-error.error_messages.2604')
		];
	}

}
