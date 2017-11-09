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
            'student_id.required' => trans('errors.1003',['attribute' => trans('errors.2192')]),
            'help_request_answer_id.required' => trans('errors.1003',['attribute' => trans('errors.2193')]),
            'student_id.integer' => trans('errors.1013',['attribute' => trans('errors.2192')]),
            'help_request_answer_id.integer' => trans('errors.1013',['attribute' => trans('errors.2193')]),
            'rating.integer' => trans('errors.1013',['attribute' => trans('errors.2194')]),
        ];
    }

}
