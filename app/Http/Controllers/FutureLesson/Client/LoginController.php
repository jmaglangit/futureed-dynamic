<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

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
		$input = Input::only('email');

		$sent = false;

		if($input['email']) {
			$sent = true;
		}

		return view('client.login.forgot-password', ['email' => $input['email'], 'sent' => $sent]);
	}

	/**
	 * Display registration screen
	 *
	 * @return Response
	 */
	public function registration()
	{
		$input = Input::only('email');
		$registered = false;

		if($input['email']) {
			$registered = true;
		}

		return view('client.login.registration', ['registered' => $registered, 'email' => $input['email']]);
	}

	/**
	 * Display reset password screen
	 *
	 * @return Response
	 */
	public function reset_password()
	{
		$input = Input::only('id', 'reset_code');
		$id = $input['id'];
		$reset_code = $input['reset_code'];

		if($id == null || $reset_code == null) {
			return redirect()->route('client.login.forgot_password');
		}

		return view('client.login.reset-password', ['id' => $id, 'reset_code' => $reset_code]);
	}
}
