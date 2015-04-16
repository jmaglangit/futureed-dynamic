<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

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
	 * Process session
	 *
	 * @return Response
	 */
	public function process()
	{
		$userdata = Input::only('response');

		if($userdata){
			Session::put('user', $userdata['response']);
			// return redirect()->route('student.dashboard.index');
			return redirect()->route('student.dashboard.follow_up_registration');
		}else{
			return redirect()->route('student.login');
		}
	}

	/**
	 * Logout
	 *
	 * @return Response
	 */
	public function logout()
	{
		Session::flush();
		return redirect()->route('student.login');
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
		$input = Input::only('email');
		$email = $input['email'];

		if($email == null) {
			return redirect()->route('student.login.forgot_password');
		}

		return view('student.login.forgot-password-success', ['email' => $email, 'title' => 'Email Sent', 'show' => 1]);
	}

	/**
	* Display enter reset code screen
	*
	* @return Response
	*/
	public function reset_code() 
	{
		$input = Input::only('email');
		$email = $input['email'];

		if($email == null) {
			return redirect()->route('student.login.forgot_password');
		}

		return view('student.login.forgot-password-success', ['email' => $email, 'title' => 'Enter Reset Code', 'show' => 0]);
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
		$input = Input::only('user_id', 'reset_code');
		$id = $input['user_id'];
		$reset_code = $input['reset_code'];

		if($id == null || $reset_code == null) {
			return redirect()->route('student.login.forgot_password');
		}

		return view('student.login.reset-password', ['id' => $id, 'reset_code' => $reset_code]);
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
