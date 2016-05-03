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

        switch($this->method()) {
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
                    'title' => 'required|max:128|min:2',
                    'content' => 'required|max:128',
                    'link_type' => 'required|in:General,Content,Question',
                    'request_status' => 'required|in:Pending,Accepted,Rejected',
                    'status' => 'required|in:Enabled,Disabled'];
                break;
            default:
                return [
                    'class_id' => 'required|integer',
                    'student_id' => 'required|integer',
                    'title' => 'required|max:128|min:2',
                    'content' => 'required|max:128',
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
            'class_id.required' => trans('errors.1003',['attribute' => trans('errors.2182')]),
            'student_id.required' => trans('errors.1003',['attribute' => trans('errors.2195')]),
            'class_id.integer' => trans('errors.1013',['attribute' => trans('errors.2182')]),
            'student_id.integer' => trans('errors.1003',['attribute' => trans('errors.2192')]),
            'module_id.integer' => trans('errors.1013',['attribute' => trans('errors.2161')]),
            'subject_id.integer' => trans('errors.1013',['attribute' => trans('errors.2155')]),
            'subject_area_id.integer' => trans('errors.1013',['attribute' => trans('errors.2196')]),
            'link_id.integer' => trans('errors.1013',['attribute' => trans('errors.2197')]),
            'content.required' => trans('validation.required',['attribute' => trans('errors.2172')]),
        ];
    }
}