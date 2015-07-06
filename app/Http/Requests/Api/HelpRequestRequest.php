<?php namespace FutureEd\Http\Requests\Api;

class HelpRequestRequest extends ApiRequest{

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
            case 'PATCH':
                switch ($this->route()->getName()) {
                    case 'help-request.patch.update-request-status':
                        return ['request_status' => 'required|in:Accepted,Rejected'];
                        break;
                    case 'help-request.patch.update-question-status':
                        return ['question_status' => 'required|in:Answered,Cancelled'];
                        break;
                }

                break;  
            case 'PUT':
                return [
                    'title' => 'required',
                    'content' => 'required',
                    'link_type' => 'required|in:General,Content,Question',
                    'request_status' => 'required|in:Pending,Accepted,Rejected',
                    'status' => 'required|in:Enabled,Disabled'];
                break;
            default:
                return [
                    'class_id' => 'required|integer',
                    'student_id' => 'required|integer',
                    'title' => 'required',
                    'content' => 'required',
                    'module_id' => 'integer',
                    'subject_id' => 'integer',
                    'subject_area_id' => 'integer',
                    'link_type' => 'in:General,Content,Question',
                    'link_id' => 'integer',
                    'request_status' => 'in:Pending,Accepted,Rejected',
                    'status' => 'in:Enabled,Disabled',
                    'question_status' => 'in:Open,Answered,Cancelled'];
        }
    }

    /**
     * Get the validation rules custom messages that apply to the request.
     *
     * @return array
     */
    public function messages() {
        return [
            'class_id.required' =>'Class is required.',
            'student_id.required' =>'User is required.',
            'class_id.integer' => 'Class must be a number.',
            'student_id.integer' => 'Student must be a number.',
            'module_id.integer' => 'Module must be a number.',
            'subject_id.integer' => 'Subject must be a number.',
            'subject_area_id.integer' => 'Subject area must be a number.',
            'link_id.integer' => 'Link must be a number.',
        ];
    }
}