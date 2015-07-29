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
			'class_id.required' => 'Class is required.',
			'class_id.integer' => 'Class is invalid.',
			'student_id.required' => 'Student is required.',
			'student_id.integer' => 'Student is invalid.',
			'module_id.required' => 'Module is required.',
			'module_id.integer' => 'Module is invalid.',
			'subject_id.required' => 'Subject is required.',
			'subject_id.integer' => 'Subject is invalid.',
			'subject_area_id.required' => 'Area is required.',
			'subject_area_id.integer' => 'Area is invalid.',
			'link_id.required' => 'Link is required.',
			'link_id.integer' => 'Link is invalid.',
			'content.required' => 'The description field is required.',
			'content.string' => 'The description field is invalid.',


		];
	}

}
