<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class ModuleQuestionTemplateRequest extends Request {

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
					'question_template_id' => 'integer',
					'template' => 'string',
					'status' => 'string'
				];
				break;
			case 'POST':
			default:
				return [
					'question_template_id' => 'required|integer',
					'template' => 'required|text',
					'status' => 'required|string'
				];
				break;
		}
	}

}
