<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class StudentPaymentRequest extends ApiRequest {

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

		switch ($this->method()) {

			case 'POST':

				return [
					'subject_id' => 'required|numeric',
					'order_date' => 'required|date_format:Ymd',
					'student_id' => 'required|numeric',
					'subscription_id' => 'required|numeric',
					'date_start' => 'required|date_format:Ymd',
					'date_end' => 'required|date_format:Ymd',
					'seats_total' => 'required|numeric|between:1,999999',
					'seats_taken' => 'numeric',
					'total_amount' => 'required|numeric|between:1,999999.99',
					'payment_status' => 'required|in:Pending,Paid,Cancelled',


				];
				break;

			case 'PUT':

				return [
					'subject_id' => 'required|numeric',
					'order_date' => 'required|date_format:Ymd',
					'student_id' => 'required|numeric',
					'subscription_id' => 'required|numeric',
					'date_start' => 'required|date_format:Ymd',
					'date_end' => 'required|date_format:Ymd',
					'seats_total' => 'required|numeric|between:1,999999',
					'seats_taken' => 'numeric',
					'total_amount' => 'required|numeric|between:1,999999.99',
					'payment_status' => 'required|in:Pending,Paid,Cancelled',


				];
				break;
		}

	}

	public function messages(){
		return [
			'subject_id.required' =>'The subject is required.',
			'subject_id.numeric' =>'The subject is invalid.',
			'student_id.required' =>'The student is required.',
			'student_id.numeric' =>'The student is invalid.',
			'subscription_id.required' =>'The subscription is required.',
			'subscription_id.numeric' =>'The subscription is invalid.',


		];
	}

}
