<?php namespace FutureEd\Http\Requests\Api;

class StudentGameRequest extends ApiRequest {

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
		if($this->method() == 'POST'){
			return [
				'user_id' => 'required|integer|exists:users,id,deleted_at,NULL',
				'games_id' => 'required|integer|exists:games,id,deleted_at,NULL'
			];
		}
	}

}
