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
					'student_id' => 'required|integer'
					,'points_to_unlock' => 'required|integer'
					,'avatar_accessories_id' => 'required|integer'
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
