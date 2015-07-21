<?php namespace FutureEd\Http\Requests\Api;

class HelpRequestAnswerRatingRequest extends ApiRequest {

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
        return [
            'student_id' => 'required|integer',
            'help_request_answer_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5'
        ];
    }

    public function messages(){

        return [
            'student_id.required' =>'Student is required.',
            'help_request_answer_id.required' =>'Help request is required.',
            'student_id.integer' =>'Student must be a number.',
            'help_request_answer_id.integer' =>'Help request must be a number.',
            'rating.integer' => 'Rating must be a number.'
        ];
    }

}
