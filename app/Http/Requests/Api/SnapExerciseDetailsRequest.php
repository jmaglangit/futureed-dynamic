<?php namespace FutureEd\Http\Requests\Api;


class SnapExerciseDetailsRequest extends ApiRequest {

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
		switch($this->method()) {
			case 'POST' :
				return [
					'student_module_id' => 'required|numeric',
					'module_id' => 'required|numeric',
					'seq_no' => 'required|numeric',
					'question_id' => 'required|numeric',
					'student_id' => 'required|numeric',
					'date_start' => 'required|date',
					'classroom_id' => 'required|numeric',
					'date_end' => 'required|date',
					'answer_text' => 'required|integer',
				];
				break;
			default :
				return [

				];
		}
	}

}
