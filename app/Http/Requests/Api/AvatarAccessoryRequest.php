<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class AvatarAccessoryRequest extends ApiRequest {

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
		switch ($this->method()) {
			case 'GET':
				return [
					'student_id' => 'required'
				];
				break;

			case 'POST':
				return [
					'user_id' => 'required'
					,'accessory_id' => 'required'
				];
				break;
			
			default:
				# code...
				break;
		}
		
	}

	public function messages() {
		return [
			'student_id.required' => 'Student ID is required.'
		];
    }

}
