<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;
use FutureEd\Models\Core\Student;

class TeacherStudentRequest extends ApiRequest {

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

			case 'PUT':

				$student_id = $this->__get('id');
				$student = Student::find($student_id);
				$student_user_id = NULL;

				if($student){

					$student_user_id = $student->user_id;
				}

				$student = config('futureed.student');
				return[
					'username' => 'required|min:'.config('futureed.username_min').'|max:'.config('futureed.username_max').'|alpha_num|unique:users,username,'.$student_user_id.',id,user_type,'.$student.',deleted_at,NULL',
					'email' => 'required|email|unique:users,email,'.$student_user_id.',id,user_type,'.$student.',deleted_at,NULL',
					'first_name'    => 'required|regex:/^([a-z\x20])+$/i|max:64',
					'last_name'     => 'required|regex:/^([a-z\x20])+$/i|max:64',
					'gender'        => 'required|alpha|in:Male,Female',
					'birth_date'    => 'required|date_format:Ymd',
					'country_id'    => 'required|integer',
					'state'         => 'required|string',
					'city'          => 'required|string',
					'grade_code'	=> 'required|integer',
					'callback_uri'  => 'required|string'
				];
				break;

			case 'POST':
				return[
					'registration_token' => 'required|string',
				];
		}


	}


	public function messages()
	{
		return [
			'country_id.required' => 'country name is required.',
			'grade_code.required' => 'grade name is required.'
		];
	}

}
