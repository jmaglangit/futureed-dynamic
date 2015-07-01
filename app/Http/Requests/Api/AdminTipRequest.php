<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class AdminTipRequest extends ApiRequest {

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
					'title' => 'required|string',
					'content' => 'required|string',
					'link_type' => 'required|alpha|in:General,Question,Content',
					'status' => 'required|alpha|in:Enabled,Disabled'
				];
		}
	}

}
