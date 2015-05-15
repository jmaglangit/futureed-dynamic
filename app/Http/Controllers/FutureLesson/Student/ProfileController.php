<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class ProfileController extends Controller {

	public function index() {
		$id = $this->getId();

		return view('student.profile.index', ['active' => 'index', 'id' => $id]);
	}

	public function profile_form() {
		return view('student.profile.index_form');
	}

	public function rewards_form() {
		return view('student.profile.rewards_form');
	}

	public function change_password_form() {
		return view('student.profile.change_password_form');
	}	

	public function avatar_form() {
		return view('student.profile.avatar_form');
	}

	public function edit_email(){
		return view('student.profile.edit_email', ['active' => 'email']);
	}

	public function update_session() {
		$user = Input::all();

		Session::forget('student');

		if(!empty($user)) {
			Session::put('student', json_encode($user));
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
		return json_decode(Session::get('student'));
	}
}