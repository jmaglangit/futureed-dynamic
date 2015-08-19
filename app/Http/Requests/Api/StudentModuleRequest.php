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
			'class_id.required' => 'Class is required.',
			'class_id.integer' => 'Class must be a number.',
			'student_id.required' => 'Student is required.',
			'student_id.integer' => 'Student must be a number.',
			'module_id.required' => 'Module is required.',
			'module_id.integer' => 'Module must be a number.',
			'subject_id.required' => 'Subject is required.',
			'subject_id.integer' => 'Subject must be a number.',
			'last_viewed_content_id.integer' => 'Content is invalid.',
			'last_answered_question_id.integer' => 'Question is invalid.',
		];
	}
}