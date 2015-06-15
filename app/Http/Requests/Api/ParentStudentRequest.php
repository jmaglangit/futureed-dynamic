<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class ParentStudentRequest extends ApiRequest {

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
		switch($this->method)
		{
			case 'POST':
				switch($this->route()->getName()){

					case 'parent-student.add.existing.student':
						return ['email'    =>   'required|email',
							'client_id'    =>   'required|integer'];
						break;
					case 'parent-student.confirm.student':
						return ['client_id'        =>   'required|integer',
							    'invitation_code'  =>   'required|integer'];
						break;
				}
		}
	}
}