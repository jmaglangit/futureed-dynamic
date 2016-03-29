<?php namespace FutureEd\Http\Requests\Api;


class StudentPasswordRequest extends ApiRequest {

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
					case 'api.v1.student.password.confirm':

						return [
							'password_image_id' => 'required|numeric'
						];
						break;

					case 'api.v1.student.password.new':

						return [
							'id' => 'required|numeric',
							'password_image_id' => 'required|numeric'
						];
						break;

					case 'api.v1.student.password.reset':

						return [
							'id' => 'required|numeric',
							'reset_code' => 'required|numeric',
							'password_image_id' => 'required|numeric'
						];
						break;

					case 'api.v1.student.password.code':

						return [
							'email' => 'required|email',
							'reset_code' => 'required|numeric'
						];
						break;

					case 'api.v1.student.password':

						return [
							'password_image_id' => 'required|numeric'
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
