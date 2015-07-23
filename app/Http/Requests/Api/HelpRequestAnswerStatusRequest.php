<?php namespace FutureEd\Http\Requests\Api;


class HelpRequestAnswerStatusRequest extends ApiRequest {

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

					'request_answer_status' => 'required|in:Accepted,Rejected',
					'rated_by' => 'required|in:Teacher,Admin',
					'rating' => 'required_if:request_answer_status,Accepted|integer',
				];

				break;
		}
	}

	public function messages(){
		return[
			'rating.required_if' => 'The rating is required.',
			'rating.integer' => 'The rating must be a number.'
		];
	}

}
