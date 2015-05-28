<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

use FutureEd\Models\Core\Admin;
use Illuminate\Support\Facades\Input;

class AdminEmailRequest extends ApiRequest {

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
		
		return ['email' => 'required|email|unique:users,email,NULL,id,user_type,'.config('futureed.admin')];
		
	}
	
	/**
	 * Get the validation rules custom messages that apply to the request.
	 *
	 * @return array
	 */
	public function messages() {
		
		$admin_id = $this->__get('id');
				
		$admin = Admin::with('user')->find($admin_id);
		
		$input = $this->only('email');
		
		$custom_messages = [];
						
		if($admin && $input) {
			$email = $input['email'];
		
			if($email == $admin->user->email) {
				$custom_messages['email.unique'] = 'The new email and the current email are the same.';
			}
		}

		return $custom_messages;
		
	}
}