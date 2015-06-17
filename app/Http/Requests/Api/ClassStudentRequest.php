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
        switch($this->method){
            case 'POST':
                switch($this->route()->getName()){
                    case 'class-student.add.existing.student':
                        return ['email'        =>   'required|email',
                            'client_id'    =>   'required',
                            'class_id'     =>   'required'];
                        break;
                    case 'class-student.add.new.student':
                        return ['first_name'    => 'required|regex:/^([a-z\x20])+$/i|max:64',
                            'last_name'     => 'required|regex:/^([a-z\x20])+$/i|max:64',
                            'gender'        => 'required|alpha|in:male,female',
                            'birth_date'    => 'required|date_format:Ymd|before:-13 year',
                            'grade_code'    => 'required|numeric',
                            'country_id'    => 'required|integer',
                            'state'         => 'required|string',
                            'city'          => 'required|string',
                            'email'         => 'required|email',
                            'username'      => 'required|min:8|max:32|alpha_num',
                            'callback_uri'  => 'required|string',
                            'client_id'     => 'required',
                            'class_id'      => 'required'];
                        break;
                    default:
                        return ['user_id'     =>   'required|email',
                            'class_id'    =>   'required',
                            'status'      =>   'required|in:Enabled,Disabled'];
                }
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
            'country_id.integer'  => 'The :attribute must be a number.',
            'country_id.required' => 'The country field is required.'
        ];
    }
}