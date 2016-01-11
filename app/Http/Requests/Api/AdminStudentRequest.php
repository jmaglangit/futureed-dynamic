<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

use FutureEd\Models\Core\Student;

class AdminStudentRequest extends ApiRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
		return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

		$student_id = $this->__get('student');

		$student = Student::find($student_id);

		$student_id = NULL;

		if ($student) {
			$student_id = $student->user_id;
		}

		switch ($this->method()) {
			case 'POST':
				$student = config('futureed.student');
				return [
					'username' => "required|alpha_num|string|min:8|max:32|unique:users,username,NULL,id,user_type,$student,deleted_at,NULL",
					'email' => "required|email|unique:users,email,NULL,id,user_type,$student,deleted_at,NULL",
					'status' => "required|string",
					'first_name' => 'required|regex:'. config('regex.name') .'|string',
					'last_name' => 'required|regex:'. config('regex.name') .'|string',
					'gender' => 'required|in:Male,Female',
					'birth_date' => 'required|date_format:Ymd',
					'city' => 'required|string',
					'state' => 'string',
					'country' => 'string',
					'country_id' => 'required|integer',
					'school_code' => 'integer',
					'grade_code' => 'required|integer',
					'callback_uri' => 'required|string',
				];
				break;
			case 'PUT':
				$student = config('futureed.student');
				return [
					'username' => "required|alpha_num|string|min:8|max:32|unique:users,username," . $student_id . ",id,user_type,$student,deleted_at,NULL",
					'email' => "required|email|unique:users,email,$student_id,id,user_type,$student,deleted_at,NULL",
					'status' => "required|string",
					'first_name' => 'required|regex:'. config('regex.name') .'|string',
					'last_name' => 'required|regex:'. config('regex.name') .'|string',
					'gender' => 'required|in:Male,Female',
					'birth_date' => 'required|date_format:Ymd',
					'city' => 'required|string',
					'state' => 'string',
					'country' => 'string',
					'country_id' => 'required|integer',
					'school_code' => 'integer',
					'grade_code' => 'required|integer',
					'points' => 'integer|min:1|max:9999'];
				break;

		}

    }

    /**
     * Get the validation rules custom messages that apply to the request.
     *
     * @return array
     */
    public function messages() {
		return [
			'grade_code.required' => 'Grade is required.',
			'grade_code.integer' => 'Grade is Invalid.',
			'country_id.required' => 'Country is required.',
			'country_id.integer' => 'Country is Invalid.',
			'school_code.integer' => 'School is Invalid.',

		];
    }
}