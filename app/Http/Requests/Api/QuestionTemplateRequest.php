<?php namespace FutureEd\Http\Requests\Api;

class QuestionTemplateRequest extends ApiRequest {

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
			case 'PUT':
				return [
					'question_type' => 'string',
					'question_template_format' => 'string',
					'question_equation' => 'string',
				];
				break;
			case 'POST':
			default:
				return [
					'question_type' => 'required|string',
					'question_template_format' => 'required|string',
					'question_equation' => 'required|string',
					'question_form' => 'required|string',
					'operation' => 'required|string'
				];
				break;
		}
	}

	public function messages(){
		return [
			'question_template_format.required' => 'The Template text field is required'
		];
	}

}
