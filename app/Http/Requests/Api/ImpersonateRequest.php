<?php namespace FutureEd\Http\Requests\Api;


class ImpersonateRequest extends ApiRequest {

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

			case 'api.v1.admin.impersonate.login':

				return [
					'id' => 'required|exists:users,id,deleted_at,NULL'
				];
				break;

			case 'api.v1.admin.impersonate.logout':

				return [
					'id' => 'required|exists:users,id,impersonate,1,deleted_at,NULL'
				];
				break;


		}
	}

}
