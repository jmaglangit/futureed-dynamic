<?php namespace FutureEd\Http\Controllers\FutureLesson\Traits;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

trait ProfileTrait{
	public function update_session(){

		$user = Input::all();

		$role = config('futureed.client');

		Session::forget($role);
		
		if(!empty($user)) {
			Session::put($role, json_encode($user));
		}
	}
}