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
					'city' => 'string',
					'state' => 'string',
					'country' => 'string',
					'country_id' => 'integer',
					'school_code' => 'integer',
					'grade_code' => 'integer',
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
					'city' => 'string',
					'state' => 'string',
					'country' => 'string',
					'country_id' => 'integer',
					'school_code' => 'integer',
					'grade_code' => 'integer',
					'points' => 'integer|min:0|max:9999'];
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
			'grade_code.required' => trans('errors.1003',['attribute' => trans('errors.2153')]),
			'grade_code.integer' => trans('errors.1004',['attribute' => trans('errors.2153')]),
			'country_id.required' => trans('errors.1003',['attribute' => trans('errors.2154')]),
			'country_id.integer' => trans('errors.1004',['attribute' => trans('errors.2154')]),
			'school_code.integer' =>  trans('errors.1004',['attribute' => trans('errors.2157')]),

		];
    }
}