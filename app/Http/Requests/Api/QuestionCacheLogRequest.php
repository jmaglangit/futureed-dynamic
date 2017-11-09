<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class QuestionCacheLogRequest extends Request {

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
					'user_id' => 'integer',
					'description' => 'text',
					'status' => 'string'
				];
				break;
			case 'POST':
			default:
				return [
					'user_id' => 'required|integer',
					'description' => 'required|text',
					'status' => 'required|string'
				];
				break;
		}
	}

}
