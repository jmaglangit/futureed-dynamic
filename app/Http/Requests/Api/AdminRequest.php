<?php namespace FutureEd\Http\Requests\Api;

use FutureEd\Http\Requests\Api\ApiRequest;

use FutureEd\Models\Core\Admin;

class AdminRequest extends ApiRequest {

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
		
		$admin_id = $this->__get('admin');
				
		$admin = Admin::find($admin_id);
		
		$admin_user_id = NULL;
		
		if($admin) {
			$admin_user_id = $admin->user_id;
		}
		
		$validation_rules = [
					'username' => 'required|min:'.config('futureed.username_min').'|max:'.config('futureed.username_max').'|alpha_num|unique:users,username,NULL,id,user_type,'.config('futureed.admin').',deleted_at,NULL',
					'admin_role' => 'required|in:Admin,Super Admin',
					'status' => 'required|in:Enabled,Disabled',
					'first_name' => 'required|regex:/^([a-z\x20])+$/i|max:'.config('futureed.first_name_max'),
					'last_name' => 'required|regex:/^([a-z\x20])+$/i|max:'.config('futureed.last_name_max')
				];
		
		switch($this->method) {
			case 'PUT':
				
				$validation_rules['username'] = 'required|min:'.config('futureed.username_min').'|max:'.config('futureed.username_max').'|alpha_num|unique:users,username,'.$admin_user_id.',id,user_type,'.config('futureed.admin');
				break;
			
			case 'POST':
			default:
				
				$validation_rules['password'] = 'required|min:'.config('futureed.password_min').'|max:'.config('futureed.password_max').'|custom_password';
				$validation_rules['email'] = 'required|email|unique:users,email,NULL,id,user_type,'.config('futureed.admin').',deleted_at,NULL';
						
	        	break;
		}
		
		return $validation_rules;
	}
	
	/**
	 * Get the validation rules custom messages that apply to the request.
	 *
	 * @return array
	 */
	public function messages() {
		return [
			'custom_password' => config('futureed-error.error_messages.2112')
		];
	}
}