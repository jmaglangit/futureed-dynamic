<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class ClassController extends Controller {
	/**
	*Display Class Index Page
	*/
	public function index($id = null) {
		$user_object = json_decode(Session::get('student'));

		if(!(isset($user_object->class) && $user_object->class)) {
			return redirect()->route('student.dashboard.index');				
		}

		if(isset($id) && !intval($id)) {
			abort(404);
		}

		return view('student.class.index', array('class_id' => $id));
	}

	/**
	*Display Class Side Nave Page
	*/
	public function dashbrd_side_nav() {
		return view('student.class.partials.dashbrd-side-nav');
	}

	/**
	*Display List of Modules
	*/
	public function module_list() {
		return view('student.class.partials.module_list');
	}

	/**
	 * Display 10 Trial Questions
	 *
	 * @return \Illuminate\View\View
	 */
	public function trial_question_list() {
		return view('student.class.partials.trial_question_list');
	}
}