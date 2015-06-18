<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

class ClassroomRequest extends ApiRequest {

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
        switch($this->method){

            case 'PUT':

                return [
                    'name' => 'required',
                ];
                break;

            case 'PATCH':
                break;

            case 'POST':
            default:
                return [
                    'order_no' => 'required|numeric',
                    'name' => 'required|regex:'. config('regex.name'),
                    'grade_id' => 'required|numeric',
                    'client_id' => 'required|numeric',
                    'seats_taken' => 'required|numeric',
                    'seats_total' => 'required|numeric',
                    'status' => 'required|in:Enabled,Disabled'
                ];
                break;
        }
	}

    //        order_no
    //name
    //grade_id
    //client_id
    //seats_taken
    //seats_total
    //status


}
