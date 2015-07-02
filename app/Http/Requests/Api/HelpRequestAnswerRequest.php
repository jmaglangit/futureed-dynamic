<?php namespace FutureEd\Http\Requests\Api;



class HelpRequestAnswerRequest extends ApiRequest {

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

			case 'PUT':

				return [
					'student_id' => 'required|exists:students,id,deleted_at,NULL',
					'content' => 'required|string',
					'help_request_id' => 'required|exists:help_requests,id,deleted_at,NULL',
					'module_id' => 'required|exists:modules,id,deleted_at,NULL',
					'subject_id' => 'required|exists:subjects,id,deleted_at,NULL',
					'subject_area_id' => 'required|exists:subject_areas,id,deleted_at,NULL',
					'rating' => 'numeric',
					'seq_no' => 'required|numeric',
					'request_answer_status' => 'required|in:Pending,Accepted,Rejected',
					'status' => 'required|in:Enabled,Disabled',
					'points' => 'required|numeric',
					'created_by' => 'required|exists:users,id,deleted_at,NULL'

				];
				break;
		}
	}

	public function messages(){

		return [

		];
	}

}
