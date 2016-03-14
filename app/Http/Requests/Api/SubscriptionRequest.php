<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;
use FutureEd\Services\ErrorMessageServices as Error;

class SubscriptionRequest extends ApiRequest {
	
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
	public function rules() {
	    switch($this->method()){
    	    case 'POST':

        	    return [
			            'name'          => 'required|regex:' . config('regex.name_numeric'),
			            'price'         => 'required|numeric|min:0.01|max:999999.99',
			            'description'   => 'required',
			            'days'          => 'required|integer',
			            'status'        => 'required|in:'.config('futureed.enabled').','.config('futureed.disabled'),
			            'has_lsp'       => 'required|in:'.config('futureed.true').','.config('futureed.false')
	            ];
    	    break;

    	    case 'PATCH':

                switch($this->route()->getName()){
                    case 'subscription.update.status':
                        return ['status' => 'required|in:'.config('futureed.enabled').','.config('futureed.disabled')];
                    break;
                    default:
                    return [
		                    'name'          => 'required|regex:' . config('regex.name_numeric'),
		                    'price'         => 'required|numeric|min:0.01|max:999999.99',
		                    'description'   => 'required',
		                    'status'        => 'required|in:'.config('futureed.enabled').','.config('futureed.disabled'),
		                    'has_lsp'       => 'required|in:'.config('futureed.true').','.config('futureed.false')
                    ];
                }

            break;

            case 'PUT':

                return [
		                'name'          => 'required|regex:'. config('regex.name_numeric'),
		                'price'         => 'required|numeric|min:0.01|max:999999.99',
		                'description'   => 'required',
		                'days'          => 'required|integer',
		                'status'        => 'required|in:'.config('futureed.enabled').','.config('futureed.disabled'),
		                'has_lsp'       => 'required|in:'.config('futureed.true').','.config('futureed.false')
                ];

                break;
	    }
	
	
	
        
	}
	
	/**
	 * Get the validation rules custom messages that apply to the request.
	 *
	 * @return array
	 */
	public function messages() {
		return [
			'numeric' => config(Error::SUBSCRIPTION_MUST_BE_A_NUMBER),
			'name.required' => config(Error::SUBSCRIPTION_NAME_REQUIRED),
			'name.regex' => config(Error::SUBSCRIPTION_NAME_INVALID),
			'has_lsp.required' => config(Error::SUBSCRIPTION_LSP_REQUIRED),
			'has_lsp.in' => config(Error::SUBSCRIPTION_LSP_INVALID)
		];
	}
}