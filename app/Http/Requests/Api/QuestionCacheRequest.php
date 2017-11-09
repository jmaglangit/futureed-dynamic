<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class QuestionCacheRequest extends Request {

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
					'module_question_template_id' => 'integer',
					'question_template_id' => 'integer',
					'question_text' => 'string',
					'status' => 'string'
				];
				break;
			case 'POST':
			default:
				return [
					'module_question_template_id' => 'required|integer',
					'question_template_id' => 'required|integer',
					'question_text' => 'required|string',
					'status' => 'required|string'
				];
				break;
		}
	}

}
