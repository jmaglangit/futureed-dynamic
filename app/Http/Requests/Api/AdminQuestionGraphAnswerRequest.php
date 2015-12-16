<?php namespace FutureEd\Http\Requests\Api;


class AdminQuestionGraphAnswerRequest extends ApiRequest {

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
				switch($this->route()->getName()){

					case 'api.v1.question.graph-answer.admin':

						return [
							'answer' => 'required|json|graph_answer:'.$this->request->get('question_type'),
							'question_type' => 'required|in:'.config('futureed.question_type_graph').','.config('futureed.question_type_quad'),
						];
						break;
				}
				break;
		}
	}

}
