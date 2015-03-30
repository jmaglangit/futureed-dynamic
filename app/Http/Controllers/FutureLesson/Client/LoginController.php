<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LoginController extends Controller {

	/**
	 * Display login screen
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('client.login.login');
	}
	
	/**
	 * Display forgot password screen
	 *
	 * @return Response
	 */
	public function forgot_password()
	{
		return view('client.login.forgot-password');
	}

	/**
	 * Display forgot password success screen
	 *
	 * @return Response
	 */
	public function forgot_password_success()
	{
		return view('client.login.forgot-password-success');
	}

	/**
	 * Display registration screen
	 *
	 * @return Response
	 */
	public function registration()
	{
		return view('client.login.registration');
	}
	
	/**
	 * Display registration success screen
	 *
	 * @return Response
	 */
	public function registration_success()
	{
		return view('client.login.registration-success');
	}
	
	/**
	 * Display reset password screen
	 *
	 * @return Response
	 */
	public function reset_password()
	{
		return view('client.login.reset-password');
	}
	
	/**
	 * Display reset password success screen
	 *
	 * @return Response
	 */
	public function reset_password_success()
	{
		return view('client.login.reset-password-success');
	}

}
