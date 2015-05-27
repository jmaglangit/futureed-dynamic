<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class ClientTeacherRequest extends ApiRequest {

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
            case 'PUT':
                return [
                    'subject_id' => 'required|integer|exists:subjects,id',
                    'name' => 'required',
                    'status' => 'required|in:Enabled,Disabled'
                ];
                break;
            case 'POST':
            default:
                return [
                    'user_name' => 'require|string',
                    'email' => 'required|email|unique:users',
                    'first_name' => 'required|string',
                    'last_name' => 'required|string',
                    'current_user' => 'required|numeric',
                    'username' => 'required|string|max:32|min:8',
                    'callback_uri' => 'required|string'
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
            'numeric' => 'The :attribute must be a number.'
        ];
    }
}