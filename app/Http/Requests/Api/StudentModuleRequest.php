<?php namespace FutureEd\Http\Requests\Api;

class StudentModuleRequest extends ApiRequest
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
		switch ($this->method()) {

			case 'PUT':

				return [
					'last_viewed_content_id' => 'integer',
					'last_answered_question_id' => 'integer'
				];
				break;
			default:
				return [
					'class_id' => 'required|integer',
					'student_id' => 'required|integer',
					'module_id' => 'required|integer',
					'subject_id' => 'required|integer'
				];
		}

	}

	public function messages()
	{
		return [
			'class_id.required' => trans('errors.1003',['attribute' => trans('errors.2182')]),
			'class_id.integer' => trans('errors.1013',['attribute' => trans('errors.2182')]),
			'student_id.required' => trans('errors.1003',['attribute' => trans('errors.2192')]),
			'student_id.integer' => trans('errors.1003',['attribute' => trans('errors.2192')]),
			'module_id.required' => trans('errors.1003',['attribute' => trans('errors.2161')]),
			'module_id.integer' => trans('errors.1013',['attribute' => trans('errors.2161')]),
			'subject_id.required' => trans('errors.1003',['attribute' => trans('errors.2155')]),
			'subject_id.integer' => trans('errors.1013',['attribute' => trans('errors.2155')]),
			'last_viewed_content_id.integer' => trans('errors.1004',['attribute' => trans('errors.2211')]),
			'last_answered_question_id.integer' => trans('errors.1004',['attribute' => trans('errors.2162')]),
		];
	}
}