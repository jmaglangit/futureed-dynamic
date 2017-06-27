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
					'description' => 'required|string|max:256',
					'common_core_area' => 'required|string',
					'common_core_url' => 'required|string',
					'status' => 'required|alpha|in:Enabled,Disabled',
					'points_to_unlock' => 'required|integer',
					'points_to_finish' => 'required|integer',
					'curriculum_country' => 'required|array',
					'is_dynamic' => 'required',
					'no_difficulty' => 'required'

				];

			case 'PUT':

				return [
					'subject_id' => 'required|integer',
					'subject_area_id' => 'required|integer',
					'name' => 'required|string',
					'description' => 'required|string|max:256',
					'common_core_area' => 'required|string',
					'common_core_url' => 'required|string',
					'status' => 'required|alpha|in:Enabled,Disabled',
					'points_to_unlock' => 'required|integer',
					'points_to_finish' => 'required|integer',
					'translatable' => 'required|integer'

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
			'points_to_unlock.integer' => trans('errors.1005',['attribute' => trans('errors.2158')]),
			'points_to_finish.integer' => trans('errors.1005',['attribute' => trans('errors.2159')]),
			'name.required' => trans('validation.required',['attribute' => trans('errors.2160')]),
			'is_dynamic.required' => trans('errors.1017',['attribute' => trans('errors.2227')]),
			'no_difficulty.required' => trans('errors.1017',['attribute' => trans('errors.2228')]),

		];
	}

}
