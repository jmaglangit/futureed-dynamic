<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class ProfileController extends Controller {

	public function index() {
		return view('student.profile.index');
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

	public function edit_email_form(){
		return view('student.profile.edit_email_form');
	}

	public function confirm_email_form() {
		return view('student.profile.confirm_email_form');
	}

	public function enter_email_code() {
		$input = Input::only('email');
		$student_session = Session::get('student');

		if(isset($student_session)) {
			return redirect()->route('student.profile.index');
		}

		if($input['email']) {
			return view('student.login.enter-email-code');	
		}
		
		return redirect()->route('student.login');
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