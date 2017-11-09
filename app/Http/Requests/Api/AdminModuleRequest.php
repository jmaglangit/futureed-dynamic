<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class AdminModuleRequest extends ApiRequest {

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
					'subject_id' => 'required|integer',
					'subject_area_id' => 'required|integer',
					'name' => 'required|string',
					'code' => 'required|integer',
					'description' => 'required|string|max:500',
//					'common_core_area' => 'required|string',
//					'common_core_url' => 'required|string',
					'status' => 'required|alpha|in:Enabled,Disabled',
					'points_to_unlock' => 'required|max:9999|regex:'. config('regex.numeric'),
					'points_to_finish' => 'required|max:9999|regex:'. config('regex.numeric'),
					'curriculum_country' => 'required|array',
					'is_dynamic' => 'required',
					'no_difficulty' => 'required',
					'translatable' => 'required|integer'

				];

			case 'PUT':

				return [
					'subject_id' => 'required|integer',
					'subject_area_id' => 'required|integer',
					'name' => 'required|string',
					'description' => 'required|string|max:500',
//					'common_core_area' => 'required|string',
//					'common_core_url' => 'required|string',
					'status' => 'required|alpha|in:Enabled,Disabled',
					'points_to_unlock' => 'required|max:9999|regex:'. config('regex.numeric'),
					'points_to_finish' => 'required|max:9999|regex:'. config('regex.numeric'),
					'translatable' => 'required|integer',
					'curriculum_country' => 'required|array',

				];
		}
	}

	/**
	 * Get the validation rules custom messages that apply to the request.
	 *
	 * @return array
	 */
	public function messages() {
		return [
			'subject_id.required' => trans('errors.1017',['attribute' => strtolower(trans('errors.2155'))]),
			'subject_id.integer' => trans('errors.1018',['attribute' => strtolower(trans('errors.2155'))]),
			'subject_area_id.required' => trans('errors.1017',['attribute' => strtolower(trans('errors.2156'))]),
			'subject_area_id.integer' => trans('errors.1018',['attribute' => strtolower(trans('errors.2156'))]),
			'points_to_unlock.regex' => trans('errors.1005',['attribute' => trans('errors.2158')]),
			'points_to_finish.regex' => trans('errors.1005',['attribute' => trans('errors.2159')]),
			'name.required' => trans('validation.required',['attribute' => trans('errors.2160')]),
			'is_dynamic.required' => trans('errors.1017',['attribute' => trans('errors.2227')]),
			'no_difficulty.required' => trans('errors.1017',['attribute' => trans('errors.2228')]),
			'translatable.required' => trans('errors.1017',['attribute' => trans('errors.2229')]),

		];
	}

}
