<?php namespace FutureEd\Http\Requests\Api;

class LanguageRequest extends ApiRequest {

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
			case 'POST' :
				return [
					'locale' => 'required|in:' . implode(",",config('translatable.locales'))
				];
				break;
			default:
				break;
		}
	}

}
