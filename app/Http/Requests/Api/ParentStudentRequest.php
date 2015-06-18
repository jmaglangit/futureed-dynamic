<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;
use FutureEd\Models\Core\Student;

class ParentStudentRequest extends ApiRequest {

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
		switch($this->method)
		{
			case 'POST':
				switch($this->route()->getName()){

					case 'parent-student.add.existing.student':
						return ['email'    =>   'required|email',
							'client_id'    =>   'required|integer'];
						break;
					case 'parent-student.confirm.student':
						return ['client_id'        =>   'required|integer',
							    'invitation_code'  =>   'required|integer'];
						break;
				}

			case 'PUT':
				$student_id = $this->__get('id');
				$student = Student::find($student_id);
				$student_user_id = NULL;

				if($student){

					$student_user_id = $student->user_id;
				}

				$student = config('futureed.student');
				return[
					'username' => 'required|min:'.config('futureed.username_min').'|max:'.config('futureed.username_max').'|alpha_num|unique:users,username,'.$student_user_id.',id,user_type,'.config('futureed.student').',deleted_at,NULL',
					'first_name'    => 'required|regex:'.config('regex.name').'|max:64',
					'last_name'     => 'required|regex:'.config('regex.name').'|max:64',
					'gender'        => 'required|alpha|in:Male,Female',
					'birth_date'    => 'required|date_format:Ymd',
					'country_id'    => 'required|integer',
					'state'         => 'required|string',
					'city'          => 'required|string'
				];


		}
	}

	/**
	 * Get the validation rules custom messages that apply to the request.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'country_id.required' => 'country name is required.',
		];
	}
}