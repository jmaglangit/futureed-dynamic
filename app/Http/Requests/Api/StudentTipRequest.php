<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class StudentTipRequest extends ApiRequest {

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
					'title' => 'required|string|max:128',
					'content' => 'required|string|max:128',
					'student_id' => 'required|integer',
					'class_id' => 'required|integer'
				];
				break;
		}
	}

	public function messages()
	{

		return [
			'student_id.required' => trans('errors.1003',['attribute' => trans('errors.2192')]),
			'student_id.integer' => trans('errors.1004',['attribute' => trans('errors.2192')]),
			'content.required' => trans('validation.required',['attribute' => trans('errors.2172')]),
			'content.string' => trans('errors.1004',['attribute' => trans('errors.2172')]),
			'class_id.required' => trans('validation.required',['attribute' => trans('errors.2182')]),
			'class_id.integer' => trans('errors.1004',['attribute' => trans('errors.2182')]),
		];
	}

}
