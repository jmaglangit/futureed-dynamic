<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class StudentQuestionContentTipRequest extends ApiRequest {

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
					'class_id' => 'required|integer',
					'student_id'=> 'required|integer',
					'title' => 'required|string|max:128|min:2',
					'content' => 'required|string',
					'module_id' => 'required|integer',
					'subject_id' => 'required|integer',
					'subject_area_id' => 'required|integer',
					'link_type' => 'required|alpha|in:Question,Content',
					'link_id' => 'required|integer'
				];
				break;
		}
	}

	/**
	 * Get the validation rules custom messages that apply to the request.
	 *
	 * @return array
	 */
	public function messages() {
		return [
			'class_id.required' => trans('errors.1003',['attribute' => trans('errors.2182')]),
			'class_id.integer' => trans('errors.1004',['attribute' => trans('errors.2182')]),
			'student_id.required' => trans('errors.1003',['attribute' => trans('errors.2192')]),
			'student_id.integer' => trans('errors.1004',['attribute' => trans('errors.2192')]),
			'module_id.required' => trans('errors.1003',['attribute' => trans('errors.2161')]),
			'module_id.integer' => trans('errors.1004',['attribute' => trans('errors.2161')]),
			'subject_id.required' => trans('errors.1003',['attribute' => trans('errors.2155')]),
			'subject_id.integer' => trans('errors.1004',['attribute' => trans('errors.2155')]),
			'subject_area_id.required' => trans('errors.1003',['attribute' => trans('errors.2156')]),
			'subject_area_id.integer' => trans('errors.1004',['attribute' => trans('errors.2156')]),
			'link_id.required' => trans('errors.1003',['attribute' => trans('errors.2197')]),
			'link_id.integer' => trans('errors.1004',['attribute' => trans('errors.2197')]),
			'content.required' => trans('validation.required',['attribute' => trans('errors.2172')]),
			'content.string' => trans('errors.1004',['attribute' => trans('errors.2172')]),
			'title.required' => trans('validation.required', ['attribute' => trans('errors.2223')]),
			'title.max' => trans('validation.max.string', ['attribute' => trans('errors.2223')]),
			'title.min' => trans('validation.min.string', ['attribute' => trans('errors.2223')])
		];
	}

}
