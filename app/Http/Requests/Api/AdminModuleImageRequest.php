<?php namespace FutureEd\Http\Requests\Api;

class AdminModuleImageRequest extends ApiRequest {
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
			case 'POST':
				return [
					'file' => 'required|mimes:jpeg,jpg,png|max:2000'
				];
				break;
		}
	}
}