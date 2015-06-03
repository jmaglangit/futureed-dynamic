<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

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

        switch($this->method) {
            case 'POST':
                $client = config('futureed.client');
                return [
                    'username' => "required|string|min:8|max:32|unique:users,username,NULL,id,user_type,$client",
                    'email' => "required|email|unique:users,email,NULL,id,user_type,$client",
                    'first_name' => 'required|string',
                    'last_name' => 'required|string',
                    'gender'   => 'required|in:Male,Female',
                    'birth_date' => 'required|date_format:Ymd|before:-13 year',
                    'city' => 'required|string',
                    'state' => 'required|string',
                    'country' => 'required|string',
                    'school_code' => 'required|integer',
                    'grade_code' => 'required|integer'
                ];
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
            'school_code.required' => 'School Name is required.',
            'grade_code.required' => 'Grade is required.'
        ];
    }
}