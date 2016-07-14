<?php namespace FutureEd\Http\Requests\Api;

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
//					'date_start' => 'required|date_format:Y-m-d H:i:s',
					'date_end' => 'required|numeric',
					'seats_total' => 'required|numeric|between:1,999999',
					'seats_taken' => 'numeric',
					'total_amount' => 'required|numeric|between:0,999999.99',
					'payment_status' => 'required|in:Pending,Paid,Cancelled',
				];
				break;

			case 'PUT':

				return [
					'subject_id' => 'required|numeric',
					'order_date' => 'required|date_format:Ymd',
					'student_id' => 'required|numeric',
					'subscription_id' => 'required|numeric',
					'date_start' => 'required|date_format:Y-m-d',
					'date_end' => 'required|date_format:Y-m-d',
					'seats_total' => 'required|numeric|between:1,999999',
					'seats_taken' => 'numeric',
					'total_amount' => 'required|numeric|between:0,999999.99',
					'payment_status' => 'required|in:Pending,Paid,Cancelled',
				];
				break;
		}

	}

	public function messages(){
		return [
			'subject_id.required' => trans('errors.1003',['attribute' => trans('errors.2155')]),
			'subject_id.numeric' => trans('errors.1004',['attribute' => trans('errors.2155')]),
			'student_id.required' => trans('errors.1003',['attribute' => trans('errors.2192')]),
			'student_id.numeric' => trans('errors.1004',['attribute' => trans('errors.2192')]),
			'subscription_id.required' => trans('errors.1003',['attribute' => trans('errors.2199')]),
			'subscription_id.numeric' => trans('errors.1004',['attribute' => trans('errors.2199')]),
		];
	}

}
