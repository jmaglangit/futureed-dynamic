<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class QuestionAnswerTranslationRequest extends Request {

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
		switch($this->route()->getName()){

			case 'question-answer-translate.google-translate':
				return [
					'target_lang' => 'required',
					'field' => 'required',
					'tagged' => 'required'
				];
				break;

			default:
				break;
		}
	}

}
