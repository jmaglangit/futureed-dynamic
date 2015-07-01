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

        return [
            'class_id' => 'required|integer',
            'student_id' => 'required|integer',
            'title' => 'required',
            'content' => 'required',
            'module_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'subject_area_id' => 'required|integer',
            'link_type' => 'required|in:General,Content,Question',
            'link_id' => 'required|integer',
            'request_status' => 'required|in:Pending,Accepted,Rejected',
            'status' => 'required|in:Enabled,Disabled',
            'question_status' => 'required|in:Open,Answered,Cancelled',
        ];
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
            'module_id.required' =>'Module is required.',
            'subject_id.required' =>'Subject is required.',
            'subject_area_id.required' =>'Subject area is required.',
            'link_id.required' =>'Link is required.',
            'class_id.integer' => 'Class must be a number.',
            'student_id.integer' => 'Student must be a number.',
            'module_id.integer' => 'Module must be a number.',
            'subject_id.integer' => 'Subject must be a number.',
            'subject_area_id.integer' => 'Subject area must be a number.',
            'link_id.integer' => 'Link must be a number.',
        ];
    }
}