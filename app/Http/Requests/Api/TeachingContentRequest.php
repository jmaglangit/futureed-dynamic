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
					'code' => 'required|integer|unique:teaching_contents,code,NULL,id,deleted_at,NULL',
					'teaching_module' => 'required|max:64',
					'description' => 'required|max:256',
					'learning_style_id' => 'required|exists:learning_styles,id,deleted_at,NULL',
					'content_url' => 'required_if:media_type_id,1|string',
					'media_type_id' => 'required|exists:media_types,id,deleted_at,NULL',
					'status' => 'required|in:Enabled,Disabled',
					'image' => 'required_if:media_type_id,3|string',
					'seq_no' => 'integer',
					'content_text' => 'required_if:media_type_id,2|string|max:255',

				];

				break;
			case 'PUT':
				return [
					'teaching_module' => 'required|max:64',
					'description' => 'required|max:256',
					'learning_style_id' => 'required|exists:learning_styles,id,deleted_at,NULL',
					'content_url' => 'required_if:media_type_id,1|string',
					'media_type_id' => 'required|exists:media_types,id,deleted_at,NULL',
					'status' => 'required|in:Enabled,Disabled',
					'seq_no' => 'integer',
					'content_text' => 'required_if:media_type_id,2|string|max:255',

				];
				break;
		}
	}

	public function messages(){

		return [
			'integer' => trans('errors.1013'),
			'learning_style_id.required' => trans('errors.1003',['attribute' => trans('errors.2217')]),
			'media_type_id.required' => trans('validation.required',['attribute' => trans('errors.2218')]),
			'module_id.required' => trans('validation.required',['attribute' => trans('errors.2161')]),
			'subject_id.required' => trans('validation.required',['attribute' => trans('errors.2155')]),
			'subject_area_id.required' => trans('validation.required',['attribute' => trans('errors.2196')]),
			'image.required_if' => trans('validation.required',['attribute' => trans('errors.2219')]),
			'content_url.required_if' => trans('validation.required',['attribute' => trans('errors.2220')]),
			'content_text.required_if' => trans('validation.required',['attribute' => trans('errors.2211')]),
			'teaching_module.required' => trans('validation.required',['attribute' => trans('errors.2221')]),
			'seq_no.integer' => trans('validation.numeric',['attribute' => trans('errors.2170')]),
		];
	}

}
