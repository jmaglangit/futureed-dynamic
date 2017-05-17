<?php namespace FutureEd\Http\Requests\Api;

class 	WordProblemDataMappingRequest extends ApiRequest {

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
					'data' => 'required'
				];
				break;
			case 'POST':
			default:

				if($this->route()->getName() == 'api.v1.word-problem-data.import.csv'){
					return [
						'file' => 'required'
					];
				} else {
					return [
						'data' => 'required'
					];
				}

				break;
		}
	}

}
