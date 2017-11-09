<?php namespace FutureEd\Http\Requests\Api;


class UserPasswordRequest extends ApiRequest {

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
	public function rules(){

		switch($this->method()){

			case 'POST':

				switch($this->route()->getName()){

					case 'api.v1.user.password.forgot':
						return [
							'username' => 'required|string',
							'user_type' => 'required|in:'.config('futureed.admin')
								.','.config('futureed.client').','.config('futureed.student'),
							'callback_uri' => 'required|string'
						];
						break;
				}
				break;
		}
	}

}


