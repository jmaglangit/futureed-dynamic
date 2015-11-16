<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class StudentReportRequest extends ApiRequest {

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

			case 'GET':

				switch($this->route()->getName()){

					case 'api.dashboard.student.progress':

						return [
						];
						break;

					case 'api.dashboard.student.progress.curriculum':

						return [
						];
						break;
				}
				break;
		}

	}

}
