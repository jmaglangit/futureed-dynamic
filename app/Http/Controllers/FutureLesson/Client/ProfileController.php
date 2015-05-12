<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Controllers\FutureLesson\Traits\ProfileTrait;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class ProfileController extends Controller {

	use ProfileTrait;

	public function index(){

		$id = $this->getId();

		return view('client.profile.index', ['active' => 'index', 'id' => $id]);
	}

	public function update_session() {

		$user = Input::all();
		$role = config('futureed.client');
		
		$this->update_session($user, $role);
		
	}

	public function changePassword() {
		$id = $this->getId();
		return view('client.profile.change_password', ['active' => 'password']);
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
