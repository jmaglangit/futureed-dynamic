<?php namespace FutureEd\Http\Requests\Api;

class UserRequest extends ApiRequest {

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

				switch($this->route()->getName()){

					case 'api.v1.user.logout':

						return [
							'id' => 'required|integer',
							'user_type' => 'required|in:'.config('futureed.student').','.config('futureed.client').','
								.config('futureed.admin'),
						];
						break;

					case 'api.v1.user.email.code':

						return [
							'email' => 'required|email|exists:users,email,user_type,'.config('futureed.client').',deleted_at,NULL',
							'email_code' => 'required|numeric|regex:'. config('regex.email_code'),
							'user_type' => 'required|in:'.config('futureed.student').','.config('futureed.client').','
								.config('futureed.admin'),
						];
						break;

					default:
						break;
				}
				break;

			default:
				break;
		}
	}

}
