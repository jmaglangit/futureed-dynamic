<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class TipRequest extends ApiRequest {

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
				switch( $this->route()->getName() ){

					case 'tip.update.status':
						return [
							'tip_status' => 'required|alpha|in:Accepted,Rejected',
							'rating' => 'required_if:tip_status,Accepted|integer',
							'rated_by' => 'required|alpha|in:Teacher,Admin'
						];
						break;
				}
				break;
		}
	}

	public function messages(){

		return [
			'rating.required_if' => 'rating is required.',

		];
	}


}
