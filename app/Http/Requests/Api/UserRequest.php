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
							'id' => 'required|integer|exists:users,id,deleted_at,NULL',
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
