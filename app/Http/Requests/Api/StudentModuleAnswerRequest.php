<?php

namespace FutureEd\Http\Requests\Api;

use FutureEd\Models\Core\Question;

class StudentModuleAnswerRequest extends ApiRequest
{
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
        $return = [
			'student_module_id' => 'required|integer',
            'module_id' => 'required|integer',
            'seq_no' => 'required|integer',
            'question_id' => 'required|integer',
            'answer_id' => 'integer',
            'answer_text' => 'string',
            'student_id' => 'required|integer',
            'total_time' => 'required|integer',
		];

		//require answer_id if question is MC.
		$question = Question::find($this->__get('question_id'));
		$question_type = $question->question_type;

		if($question_type == config('futureed.question_type_multiple_choice')){

			$return['answer_id'] = 'integer|required|exists:question_answers,id,deleted_at,NULL,question_id,'. $question->id ;
		}

		return $return;
    }

    public function messages()
    {
        return [
            'student_module_id.required' => 'Class is required.',
            'student_module_id.integer' => 'Class must be a number.',
            'module_id.required' => 'Module is required.',
            'module_id.integer' => 'Module must be a number.',
            'seq_no.required' => 'Sequence number is required.',
            'seq_no.integer' => 'Sequence number must be a number.',
            'question_id.required' => 'Question is required.',
            'question_id.integer' => 'Question must be a number.',
            'answer_id.required' => 'Answer is required.',
            'answer_id.integer' => 'Answer must be a number.',
            'student_id.required' => 'Student is required.',
            'student_id.integer' => 'Student must be a number.',
        ];
    }
}