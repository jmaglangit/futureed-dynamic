<?php namespace FutureEd\Http\Requests\Api;

class AdminAnswerExplanationTemplateRequest extends ApiRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return false;
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
					'module_id' => 'integer',
					'question_module_id' => 'integer',
					'status' => 'string'
				];
				break;
			case 'POST':
			default:
				return [
					'module_id' => 'required|integer',
					'question_template_id' => 'required|integer',
					'status' => 'required|string'
				];
				break;
		}
	}

}
