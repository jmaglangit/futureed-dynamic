<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class ClientStudentRequest extends ApiRequest {

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
	public function rules() {
		switch($this->method){
			case 'POST':
			default:
				$student = config('futureed.student');
				return[
					'username' => "required|string|min:8|max:32|unique:users,username,NULL,id,user_type,$student,deleted_at,NULL",
					'email' => "required|email|unique:users,email,NULL,id,user_type,$student,deleted_at,NULL",
					'first_name'    => 'required|regex:/^([a-z\x20])+$/i|max:64',
					'last_name'     => 'required|regex:/^([a-z\x20])+$/i|max:64',
					'gender'        => 'required|alpha|in:Male,Female',
					'birth_date'    => 'required|date_format:Ymd',
					'country_id'    => 'required|integer',
					'state'         => 'required|string',
					'city'          => 'required|string',
					'callback_uri'  => 'required|string',
					'client_id'     => 'required|integer'
				];
				break;
		}


	}

}
