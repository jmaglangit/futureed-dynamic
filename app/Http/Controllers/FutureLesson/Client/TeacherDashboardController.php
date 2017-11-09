<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TeacherDashboardController extends Controller {

	/**
	 * Get Teacher dashboard view.
	 * @return \Illuminate\View\View
	 */
	public function index(){
		return view('client.teacher.dashboard.index');
	}

}
