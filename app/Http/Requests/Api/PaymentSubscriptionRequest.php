<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Request;

class PaymentSubscriptionRequest extends ApiRequest {

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

					case 'subscription.save':
						return [
							'subject_id' => 'required|numeric',
							'order_date' => 'required|date_format:Ymd',
							'student_id' => 'required|numeric',
							'subscription_id' => 'required|numeric|exists:subscription,id,deleted_at,NULL',
							'date_start' => 'required|date_format:Ymd',
							'date_end' => 'required|date_format:Ymd',
							'seats_total' => 'required|numeric|between:1,999999',
							'seats_taken' => 'numeric',
							'total_amount' => 'required|numeric|between:1,999999.99',
							'payment_status' => 'required|in:Pending,Paid,Cancelled',
							'discount_id' => 'numeric|exists:client_discounts,id,deleted_at,NULL',
							'subscription_package_id' => 'required|numeric|exists:subscription_packages,id,deleted_at,NULL',
						];
						break;
					case 'subscription.pay':
						return [
							'subject_id' => 'required|numeric',
							'order_date' => 'required|date_format:Ymd',
							'subscription_id' => 'required|numeric|exists:subscription,id,deleted_at,NULL',
							'date_start' => 'required|date_format:Ymd',
							'date_end' => 'required|date_format:Ymd',
							'seats_taken' => 'numeric',
							'total_amount' => 'required|numeric|between:1,999999.99',
							'payment_status' => 'required|in:Pending,Paid,Cancelled',
							'discount_id' => 'numeric|exists:client_discounts,id,deleted_at,NULL',
							'subscription_package_id' => 'required|numeric|exists:subscription_packages,id,deleted_at,NULL',
						];
						break;
					default:
						return [
							'order_date' => 'required|date_format:Ymd',
							'date_start' => 'required|date_format:Ymd',
							'date_end' => 'required|date_format:Ymd',
							'discount' => 'required|numeric|between:0,999.99',
							'total_amount' => 'required|numeric|between:1,999999.99'

						];
						break;
				}
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
