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
			//  Required
			'first_name'=> 'required|min:2|regex:'. config('regex.name') .'|max:64',
			'last_name' => 'required|min:2|regex:'. config('regex.name') .'|max:64',
			'gender'    => 'required|alpha|in:'.config('futureed.gender.male').','.config('futureed.gender.female'),
			'birth_date'=> 'required|date_format:Ymd|before:-14 year',
			'email'     => 'required|email',
			'username'  => 'required|min:8|max:32|alpha_num',

			//  Not required
			'grade_code'=> 'numeric',
			'country_id'=> 'numeric',
			'city'      => 'max:128|regex:'.config('regex.state_city'),
			'state'     => 'max:128|regex:'.config('regex.state_city'),

		];
	}

	public function messages()
	{
		return [
			'birth_date.before' => trans('errors.2117'),
			'grade_code.numeric' => trans('errors.2023'),
			'country_id.numeric' =>  trans('errors.1004',['attribute' => trans('errors.2154')]),
		];
	}

}
