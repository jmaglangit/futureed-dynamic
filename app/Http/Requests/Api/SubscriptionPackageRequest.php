<?php namespace FutureEd\Http\Requests\Api;

class SubscriptionPackageRequest extends ApiRequest {

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
		if($this->method() == 'POST' || $this->method() == 'PUT'){
			return [
				'days_id'	=> 'required|integer|exists:subscription_days,id,deleted_at,NULL',
				'subscription_id'	=> 'required|integer|exists:subscription,id,deleted_at,NULL',
				'country_id'	=> 'required|integer|exists:countries,id',
				'subject_id'	=> 'required|integer|exists:subjects,id,deleted_at,NULL',
				'price'	=> 'required|numeric|between:0,999999.99',
				'status'	=> 'required|in:'.config('futureed.enabled').','.config('futureed.disabled')
			];
		}
	}

}
