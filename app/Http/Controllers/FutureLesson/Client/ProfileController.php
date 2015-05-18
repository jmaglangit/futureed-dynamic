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

	public function index_form() {
		return view('client.profile.index_form');
	}

	public function edit_email_form() {
		return view('client.profile.change_email_form');
	}

	public function confirm_email_form() {
		return view('client.profile.confirm_email_form');
	}

	public function change_password_form() {
		return view('client.profile.change_password_form');
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
