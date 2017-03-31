<?php namespace FutureEd\Http\Requests\Api;

class 	DataLibraryRequest extends ApiRequest {

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
	public function rules()
	{
		switch($this->method()){
			case 'PUT' :

				return [
					'object_type' => 'string',
					'object_name' => 'string',
					'status' => 'string'
				];
				break;
			case 'POST':
			default:
				if($this->route()->getName() == 'api.v1.data-library.import.csv'){
					return [
						'file' => 'required'
					];
				} else {
					return [
						'object_type' => 'required|string',
						'object_name' => 'required|string',
						'status' => 'required|string'
					];
				}
				break;
		}
	}

}
