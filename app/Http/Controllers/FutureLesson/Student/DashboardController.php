<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class DashboardController extends Controller {

	/**
	 * Display dashboard screen
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('student.dashboard.index');
	}

	/**
	 * Display my profile screen
	 *
	 * @return Response
	 */
	public function my_profile()
	{
		return view('student.dashboard.my-profile');
	}

	/**
	 * Display my follow up registration screen
	 *
	 * @return Response
	 */
	public function follow_up_registration()
	{
		return view('student.dashboard.follow-up-registration');
	}

}