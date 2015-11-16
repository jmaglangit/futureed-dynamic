<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PrincipalDashboardController extends Controller {

	/**
	 * Get Principal dashboard view.
	 * @return \Illuminate\View\View
	 */
	public function index(){
		return view('client.principal.dashboard.index');
	}
}
