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
			'test_id.required' => trans('errors.1003',['attribute' => trans('errors.2204')]),
			'student_id.required' => trans('errors.1003',['attribute' => trans('errors.2192')]),
			'student_id.exists' => trans('errors.1014',['attribute' => trans('errors.2192')]),
			'student_id.integer' => trans('errors.1004',['attribute' => trans('errors.2192')]),
			'section_id.required' => trans('errors.1003',['attribute' => trans('errors.2205')]),
			'user_answers.required' => trans('errors.1003',['attribute' => trans('errors.2171')]),
		];

		return $custom_messages;
		
	}
}