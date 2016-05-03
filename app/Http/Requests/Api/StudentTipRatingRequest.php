<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class StudentTipRatingRequest extends ApiRequest {

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
						'tip_id' => 'required|integer',
						'student_id'=> 'required|integer',
						'rating' => 'required|integer',
					];
					break;
			}
	}

	public function messages()
	{

		return [
			'tip_id.required' => trans('errors.1003',['attribute' => trans('errors.2214')]),
			'tip_id.integer' => trans('errors.1004',['attribute' => trans('errors.2214')]),
			'student_id.required' => trans('errors.1003',['attribute' => trans('errors.2192')]),
			'student_id.integer' => trans('errors.1004',['attribute' => trans('errors.2192')]),

		];
	}

}
