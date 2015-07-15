<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class TeachingContentRequest extends ApiRequest {

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

			case 'POST':

				return [
					'module_id' => 'required|exists:modules,id,deleted_at,NULL',
					'subject_id' => 'required|exists:subjects,id,deleted_at,NULL',
					'subject_area_id' => 'required|exists:subject_areas,id,deleted_at,NULL',
					'code' => 'required|integer',
					'teaching_module' => 'required',
					'description' => 'required',
					'learning_style_id' => 'required|exists:learning_styles,id,deleted_at,NULL',
					'content_url' => 'required|url',
					'media_type_id' => 'required|exists:media_types,id,deleted_at,NULL',
					'status' => 'required|in:Enabled,Disabled'
				];

				break;
			case 'PUT':
				return [
					'teaching_module' => 'required',
					'description' => 'required',
					'learning_style_id' => 'required|exists:learning_styles,id,deleted_at,NULL',
					'content_url' => 'required|url',
					'media_type_id' => 'required|exists:media_types,id,deleted_at,NULL',
					'status' => 'required|in:Enabled,Disabled'
				];
				break;
		}
	}

	public function messages(){

		return [
			'integer' => 'The :attribute must be a number',
			'learning_style_id.required' => 'The learning style field is required.',
			'media_type_id.required' => 'The media type field is required.',
			'module_id.required' => 'The module field is required.',
			'subject_id.required' => 'The subject field is required.',
			'subject_area_id.required' => 'The subject area field is required.',
		];
	}

}
