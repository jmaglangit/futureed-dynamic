<?php namespace FutureEd\Http\Requests\Api;

class ClientRequest extends ApiRequest {

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
		switch($this->route()->getName()) {
			case 'api.v1.client.update.billing-address':
				return [
					'country_id' => 'numeric',
					'city' => 'max:128|regex:' . config('regex.state_city'),
					'state' => 'max:128|regex:' . config('regex.state_city')
				];
				break;
			default:

				$default_validations = [
					'username' => 'required|min:8|max:32|alpha_num',
					'email' => 'required|email',
					'first_name' => 'required|min:2|regex:' . config('regex.name') . '|max:64',
					'last_name' => 'required|min:2|regex:' . config('regex.name') . '|max:64',
				];
				$common_validations = [];
				$specific_role_validations = [];
				$role = $this->input('client_role');
				switch ($this->method()) {
					case 'PUT':
						$common_validations = [
							'id' => 'required|numeric',
							'street_address' => 'string|max:128',
							'city' => 'max:128|regex:' . config('regex.state_city'),
							'country' => 'string|max:128',
							'country_id' => 'numeric',
							'state' => 'max:128|regex:' . config('regex.state_city'),
							'zip' => 'max:10|regex:' . config('regex.zip_code')
						];

						if ($role === config('futureed.principal')) {
							$specific_role_validations = [
								'school_code' => 'required|numeric|exists:schools,code,deleted_at,NULL',
								'school_name' => 'required|string|max:128',
								'school_state' => 'required|max:128|regex:' . config('regex.state_city'),
								'school_country' => 'string|max:128',
								'school_country_id' => 'required|numeric',
								'school_street_address' => 'required|string|max:128',
								'school_city' => 'max:128|regex:' . config('regex.state_city'),
								'school_zip' => 'max:10|regex:' . config('regex.zip_code'),
								'school_contact_name' => 'required|min:2|regex:' . config('regex.name') . '|max:128',
								'school_contact_number' => 'required|max:20|regex:' . config('regex.phone')
							];
						}
						break;
					case 'POST':

						$common_validations = [
							'client_role' => 'required|in:' . config('futureed.parent') . ',' . config('futureed.principal') . ',' . config('futureed.teacher'),
							'callback_uri' => 'required|string|max:128',
							'status' => 'required|in:Enabled,Disabled',
							'street_address' => 'string|max:128',
							'country' => 'string|max:128',
							'country_id' => 'numeric',
							'zip' => 'max:10|regex:' . config('regex.zip_code'),
							'city' => 'max:128|regex:' . config('regex.state_city'),
							'state' => 'max:128|regex:' . config('regex.state_city'),
						];

						if ($role == config('futureed.teacher')) {
							$specific_role_validations = [
								'school_name' => 'required|string|max:128',
							];
						}

						if ($role === config('futureed.principal') || $role === config('futureed.parent')) {
							if (strtolower($role) === config('futureed.principal')) {
								$principal_validations = [
									'school_name' => 'required|string|max:128',
									'school_state' => 'required|string|max:128',
									'school_country' => 'string|max:128',
									'school_country_id' => 'required|numeric',
									'school_address' => 'required|string|max:128',
									'school_city' => 'string|max:128',
									'school_zip' => 'max:10|regex:' . config('regex.zip_code'),
									'contact_name' => 'required|min:2|regex:' . config('regex.name') . '|max:128',
									'contact_number' => 'required|max:20'
								];
								$specific_role_validations = array_merge($specific_role_validations, $principal_validations);
							}
						}

						break;
				}
				break;
		}
		return (array_merge($default_validations, $specific_role_validations, $common_validations));
	}

	/**
	 * Validation Messages
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'zip.max' => trans('errors.1009',['attribute' => trans('errors.2187')]),
			'zip.regex' =>  trans('errors.1008',['attribute' => trans('errors.2187')]),

			'school_code.exist' => trans('errors.1004',['attribute' => trans('errors.2157')]),
			'school_code.required' => trans('errors.1004',['attribute' => trans('errors.2157')]),
			'school_code.numeric' => trans('errors.1004',['attribute' => trans('errors.2157')]),
			'school_contact_number.max' => trans('errors.1011',['attribute' => trans('errors.2188')]),
			'school_contact_number.regex' => trans('errors.1010',['attribute' => trans('errors.2188')]),
			'school_country_id.required' => trans('validation.required',['attribute' => trans('errors.2154')]),
			'school_country_id.numeric' => trans('validation.numeric',['attribute' => trans('errors.2154')]),

			'country_id.required' => trans('validation.required',['attribute' => trans('errors.2154')]),
			'country_id.numeric' => trans('validation.numeric',['attribute' => trans('errors.2154')]),

			'contact_number.max' => trans('errors.1011',['attribute' => trans('errors.2188')]),

			'password_image_id.required' => trans('errors.1003',['attribute' => 'errors.2189']),
		];
	}

}
