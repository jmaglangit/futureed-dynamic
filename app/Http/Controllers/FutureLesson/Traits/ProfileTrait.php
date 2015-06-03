<?php namespace FutureEd\Http\Controllers\FutureLesson\Traits;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

trait ProfileTrait{
	public function update_session(){

		$user = Input::all();

		$role = config('futureed.client');

		Session::forget($role);
		
		if(!empty($user)) {
			Session::put($role, json_encode($user));
		}
	}

	public function validate_email($email){

		$validator = Validator::make(
			[
				"email" => $email['email']
			],
			[
				"email" => "email"
			]
		);

		if($validator->fails()){

			return false;
		}
		else
		{
			return true;
		}
	}
}