<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class ProfileController extends Controller {

	public function index(){

		$id = $this->getId();

		return view('client.profile.index', ['active' => 'index', 'id' => $id]);
	}

	public function update_session() {
		$user = Input::all();

		Session::forget('client');
		
		if(!empty($user)) {
			Session::put('client', json_encode($user));
		}
	}

	public function getId() {
		$user = $this->getUserObject();
		if(isset($user)) {
			$user->id;
		}

		return null;
	}

	public function getUserObject() {
		return json_decode(Session::get('client'));
	}
}
