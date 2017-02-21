<?php namespace FutureEd\Http\Requests\Api;

use Carbon\Carbon;
use FutureEd\Http\Requests\Request;

class StudentRegistrationRequest extends ApiRequest {

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
			//Required
			'first_name'    => 'required|min:2|regex:'.config('regex.name').'|max:64',
			'last_name'     => 'required|min:2|regex:'.config('regex.name').'|max:64',
			'gender'        => 'required|alpha|in:'.config('futureed.gender.male').','.config('futureed.gender.female'),
			'birth_date'    => 'required|date_format:Ymd|before:' . Carbon::now()->subYears(14)->addDay(1)->toDateString(),
			'username'      => 'required|min:8|max:32|alpha_num',
			'callback_uri'  => 'required|string|max:128',
			'email'         => 'required|email',

			//Not required
			'grade_code'    => 'numeric',
			'country_id'    => 'numeric',
			'state'         => 'max:128|regex:'.config('regex.state_city'),
			'city'          => 'max:128|regex:'.config('regex.state_city'),
		];
	}

	public function messages()
	{
		return [
			'birth_date.before'     => trans('errors.2028'),
			'grade_code.numeric'    => trans('errors.2023'),
			'country_id.numeric'    => trans('errors.2604'),
			'birth_date.date_format'=> trans('errors.2079')
		];
	}
}
