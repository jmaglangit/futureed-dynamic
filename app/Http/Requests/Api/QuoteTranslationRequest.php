<?php namespace FutureEd\Http\Requests\Api;

class QuoteTranslationRequest extends ApiRequest {

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

			case 'quote-translate.google-translate':
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
