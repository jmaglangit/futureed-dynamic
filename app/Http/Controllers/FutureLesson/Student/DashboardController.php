<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;

class DashboardController extends Controller {
	/**
	 * Display dashboard screen
	 *
	 * @return Response
	 */
	public function index()
	{
		$user_object = json_decode(Session::get('student'));

		if(!(is_numeric($user_object->avatar_id))) {
			return redirect()->route('student.dashboard.follow_up_registration');
		}

		if(isset($user_object->class) && $user_object->class) {
			return view('student.class.index', array('class_id' => null));
		}

		return view('student.dashboard.index');
	}

	/**
	 * Display my follow up registration screen
	 *
	 * @return Response
	 */
	public function follow_up_registration()
	{
		$user_object = json_decode(Session::get('student'));

		if($user_object) {
			if(is_numeric($user_object->avatar_id)) {
				return redirect()->route('student.dashboard.index');
			}
		}
		
		return view('student.dashboard.follow-up-registration');
	}
}