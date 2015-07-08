<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class TeachingContent extends ApiRequest {

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
		switch ($this->method) {

			case 'POST':

				return [
					'module_id' => 'required|exists:modules,id,deleted_at,NULL',
					'subject_id' => 'required|exists:subjects,id,deleted_at,NULL',
					'subject_area_id' => 'required|exists:subject_areas,id,deleted_at,NULL',
					'code' => 'integer',
					'teaching_module' => 'required',
					'description' => 'required',
					'learning_style_id' => 'required|exists:learning_styles,id,deleted_at,NULL',
					'content_url' => 'required|url',
					'media_type_id' => 'required|exists:media_types,id,deleted_at,NULL',
					'seq_no' => 'required|integer',
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
					'seq_no' => 'required|integer',
					'status' => 'required|in:Enabled,Disabled'
				];
				break;
		}
	}

	public function messages(){

		return [
			'integer' => 'The :attribute must be a number',
			'seq_no.required' => 'The sequence number is required.',
			'seq_no.integer' => 'The sequence must be a number'
		];
	}

}
