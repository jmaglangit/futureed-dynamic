<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

use Illuminate\Support\Facades\Input;

class LearningStyleRequest extends ApiRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		
		return [
			'test_id' => 'required',
			'student_id' => 'required|exists:students,id,deleted_at,NULL|integer',
			'section_id' => 'required',
			'user_answers' => 'required'
		];
		
	}
	
	/**
	 * Get the validation rules custom messages that apply to the request.
	 *
	 * @return array
	 */
	public function messages() {
		
		$custom_messages = [
			'test_id.required' => 'Test is required.',
			'student_id.required' => 'Student is required.',
			'student_id.exists' => 'Student does not exist.',
			'student_id.integer' => 'Student is invalid.',
			'section_id.required' => 'Section is required.',
			'user_answers.required' => 'Answers are required.'
		];

		return $custom_messages;
		
	}
}