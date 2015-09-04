<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class ClassStudentRequest extends ApiRequest {

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
		switch ($this->method()) {
			case 'POST':
				switch ($this->route()->getName()) {
					case 'class-student.add.existing.student':
						return [
							'email' => 'required|email',
							'client_id' => 'required',
							'class_id' => 'required'];
						break;
					case 'class-student.add.new.student':
						return [
							'first_name' => 'required|regex:'. config('regex.name') .'|max:64',
							'last_name' => 'required|regex:'. config('regex.name') .'|max:64',
							'gender' => 'required|alpha|in:male,female',
							'birth_date' => 'required|date_format:Ymd',
							'grade_code' => 'required|numeric',
							'country_id' => 'required|integer',
							'state' => 'string',
							'city' => 'required|string',
							'email' => 'required|email',
							'username' => 'required|min:8|max:32|alpha_num',
							'callback_uri' => 'required|string',
							'client_id' => 'required',
							'class_id' => 'required'];
						break;
					default:
						return ['user_id' => 'required|email',
							'class_id' => 'required',
							'status' => 'required|in:Enabled,Disabled'];
				}
				break;

			case 'GET':
				switch ($this->route()->getName()) {

					case 'api.v1.class-student.student-current-class';

						return [
							'student_id' => 'required|exists:class_students,student_id,deleted_at,NULL',
							'class_id' => 'required|exists:classrooms,id,deleted_at,NULL',
							'grade_id' => 'exists:grades,id,deleted_at,NULL',
							'module_status' => 'in:'. config('futureed.module_status_available')
								.','.config('futureed.module_status_ongoing')
								.','.config('futureed.module_status_completed')
								.','.config('futureed.module_status_failed'),
						];
						break;
				}
				break;

			case 'PUT':return['date_removed' => 'required|date_format:Ymd'];
        }




    }

    /**
     * Get the validation rules custom messages that apply to the request.
     *
     * @return array
     */
    public function messages() {
		return [
			'country_id.integer' => 'country is invalid.',
			'country_id.required' => 'The country field is required.',
			'grade_code.required' => 'The grade field is required.',
			'grade_code.numeric' => 'grade is invalid.',
			'class_id.required' => 'The class field is required.',
		];
    }
}