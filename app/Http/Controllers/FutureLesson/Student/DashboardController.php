<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
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
			return view('student.class.index', array('class_id' => $user_object->class));
		}

		// This will work/execute after the student.dashboard.index-trial calls the class.checkStudentSubscription()
		// This acts as a fail-safe when $user_object->class returns null, or 0(for unknown reasons in beta)
		// even if student has a subscription
		if(Input::get('class')){
			return view('student.class.index', array('class_id' => null));
		}

		return view('student.dashboard.index-trial');
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