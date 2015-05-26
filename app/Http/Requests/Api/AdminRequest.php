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
				
		switch($this->method) {
			case 'PUT':
				return [
					'username' => 'required|min:8|max:32|alpha_num|unique:users,username,'.$admin_user_id.',id,user_type,'.config('futureed.admin'),
					'admin_role' => 'required|in:Admin,Super Admin',
					'status' => 'required|in:Enabled,Disabled',
					'first_name' => 'required|regex:/^([a-z\x20])+$/i|max:64',
					'last_name' => 'required|regex:/^([a-z\x20])+$/i|max:64'
				];
				break;
			case 'POST':
			default:
				return [
					'username' => 'required|min:8|max:32|alpha_num|unique:users,username,NULL,id,user_type,'.config('futureed.admin'),
					'email' => 'required|email|unique:users,email,NULL,id,user_type,'.config('futureed.admin'),
					'admin_role' => 'required|in:Admin,Super Admin',
					'status' => 'required|in:Enabled,Disabled',
					'first_name' => 'required|regex:/^([a-z\x20])+$/i|max:64',
					'last_name' => 'required|regex:/^([a-z\x20])+$/i|max:64'
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
		];
	}
}