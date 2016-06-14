<?php namespace FutureEd\Http\Requests\Api;

class SubscriptionDayRequest extends ApiRequest {

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
				return [
					'days'	=> 'required|integer',
					'status'	=> 'required|in:'.config('futureed.enabled').','.config('futureed.disabled')
				];
				break;
			case 'PUT':
				return [
					'days'	=> 'required|integer',
					'status'	=> 'required|in:'.config('futureed.enabled').','.config('futureed.disabled')
				];
				break;
		}
	}

}
