<?php namespace FutureEd\Http\Requests\Api;

class AdminQuestionRequest extends ApiRequest {

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
		switch($this->method()){

			case 'POST':

				return [

					'image' => 'string',
					'module_id' => 'required|integer',
					'questions_text' => 'required|string',
					'difficulty' => 'required|integer',
					'status' => 'required|alpha|in:Enabled,Disabled',
					'question_type' => 'required|alpha|in:MC,FIB,O,N,GR,QUAD',
					'points_earned' => 'required|integer',
					'code' => 'required|integer|unique:questions,code,NULL,id,deleted_at,NULL',
					'answer' => 'required_if:question_type,FIB,O,N|string',
					'question_order_text' => 'required_if:question_type,O|string',
					'seq_no' => 'integer|min:1',
					'orientation' => 'required_if:question_type,GR|in:horizontal,vertical'
				];
				break;

			case 'PUT':

				return [
					'image' => 'string',
					'seq_no' => 'integer',
					'questions_text' => 'required|string|max:256',
					'difficulty' => 'required|integer',
					'status' => 'required|alpha|in:Enabled,Disabled',
					'question_type' => 'required|alpha|in:MC,FIB,O,N',
					'points_earned' => 'required|integer',
					'answer' => 'string',
					'question_order_text' => 'required_if:question_type,O|string',
				];
				break;
		}
	}


	public function messages()
	{
		return [
			'module_id.required' => 'Module is required.',
			'module_id.integer' => 'Module is invalid.',
			'difficulty.integer' => 'Difficulty is invalid.',
			'points_earned.integer' => 'Points earned is invalid.',
			'code.integer' => 'Code is invalid.',
			'seq_no.integer' => 'Sequence number is invalid.',
			'answer.required_if' => 'The answer field is required.',
			'question_order_text.required_if' => 'Question order text is required.'

		];
	}

}
