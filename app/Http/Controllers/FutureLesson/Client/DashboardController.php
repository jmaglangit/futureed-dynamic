<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

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
		return view('client.dashboard.index');
	}
}