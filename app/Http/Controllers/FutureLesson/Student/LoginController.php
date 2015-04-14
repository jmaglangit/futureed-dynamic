<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

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
		return view('student.login.login');
	}

	/**
	 * Display enter password screen
	 *
	 * @return Response
	 */
	public function enter_password()
	{
		$input = Input::only('id');
		$id = $input['id'];

		if($id == null) {
			return redirect()->route('student.login');
		}

		return view('student.login.enter-password', ['id' => $input['id']]);
	}
	
	/**
	 * Display forgot password screen
	 *
	 * @return Response
	 */
	public function forgot_password()
	{
		return view('student.login.forgot-password');
	}

	/**
	 * Display forgot password success screen
	 *
	 * @return Response
	 */
	public function forgot_password_success()
	{
		return view('student.login.forgot-password-success', ["email" => "asd@asd.com"]);
	}

	/**
	 * Display registration screen
	 *
	 * @return Response
	 */
	public function registration()
	{
		return view('student.login.registration');
	}
	
	/**
	 * Display registration success screen
	 *
	 * @return Response
	 */
	public function registration_success()
	{
		return view('student.login.registration-success');
	}
	
	/**
	 * Display reset password screen
	 *
	 * @return Response
	 */
	public function reset_password()
	{
		return view('student.login.reset-password');
	}
	
	/**
	 * Display reset confirm password screen
	 *
	 * @return Response
	 */
	public function reset_confirm_password()
	{
		return view('student.login.reset-confirm-password');
	}
	
	/**
	 * Display reset password success screen
	 *
	 * @return Response
	 */
	public function reset_password_success()
	{
		return view('student.login.reset-password-success');
	}

}
