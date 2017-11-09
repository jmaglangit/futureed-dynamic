<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class AdminQuestionAnswerRequest extends ApiRequest {

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
		switch($this->method()) {

			case 'POST':
				return [

					'module_id' => 'required|integer',
					'question_id' => 'required|integer',
					'code' => 'required|integer',
					'answer_text' => 'required_if:image,|string',
					'image' => 'required_if:answer_text,|string',
					'correct_answer' => 'required|alpha|in:Yes,No',
					'point_equivalent' => 'required|integer',
					'label' => 'string'

				];
				break;

			case 'PUT':
				return [

					'answer_text' => 'required_if:answer_image,|string',
					'correct_answer' => 'required|alpha|in:Yes,No',
					'point_equivalent' => 'required|integer',
					'image' => 'required_if:answer_text,|string',
					'label' => 'string'


				];
				break;
		}
	}


	public function messages()
	{
		return [

			'module_id.required' => trans('errors.1003',['attribute' => trans('errors.2161')]),
			'module_id.integer' => trans('errors.1004',['attribute' => trans('errors.2161')]),
			'question_id.required' => trans('errors.1003',['attribute' => trans('errors.2162')]),
			'question_id.integer' => trans('errors.1004',['attribute' => trans('errors.2162')]),
			'code.integer' =>  trans('validation.numeric',['attribute' => trans('errors.2163')]),
			'point_equivalent.integer' => trans('validation.numeric',['attribute' => trans('errors.2164')]),
			'answer_text.required_if' => trans('validation.required_if',[
				'attribute' => trans('errors.2165'),
				'other' => trans('errors.2166'),
				'value' => trans('errors.2167')
			]),
			'image.required_if' =>  trans('validation.required_if',[
				'attribute' => trans('errors.2166'),
				'other' => trans('errors.2165'),
				'value' => trans('errors.2167')
			]),


		];
	}

}
