<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class ProfileController extends Controller {

	public function index() {
		$id = $this->getId();

		return view('student.profile.index', ['active' => 'index', 'id' => $id]);
	}

	public function rewards() {
		return view('student.profile.rewards', ['active' => 'rewards']);
	}

	public function change_password() {
		$id = $this->getId();
		return view('student.profile.change_password', ['active' => 'password']);
	}	

	public function change_avatar() {
		return view('student.profile.change_avatar', ['active' => 'avatar']);
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