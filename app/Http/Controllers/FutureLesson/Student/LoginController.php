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
		if(Session::get('user')) {
			return view('student.dashboard.index');
		}

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

		return redirect()->route('student.login.reset_code')->with('email', $email);
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
		$show = 0;

		if($email == null){
			$email = Session::get('email');
			$show = 1;
		}

		if($email == null) {
			return redirect()->route('student.login.forgot_password');
		}
		
		return view('student.login.enter-code')->with(array('email' => $email, 'show' => $show));
	}

	/**
	 * Display registration screen
	 *
	 * @return Response
	 */
	public function registration()
	{
		$input = Input::only('email');
		$success = false;

		if($input['email']) {
			$success = true;
		}

		return view('student.login.registration', ['success' => $success, 'email' => $input['email']]);
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
		$input = Input::only('id', 'reset_code', 'confirmation_code', 'email');
		$id = $input['id'];
		$email = $input['email'];
		$new = false;

		if($input['reset_code'] != NULL) {
			$code = $input['reset_code'];
		} else {
			$code = $input['confirmation_code'];
			$new = true;
		}

		if($id == null || $code == null) {
			return redirect()->route('student.login.forgot_password');
		}

		return view('student.login.reset-password', ['id' => $id, 'code' => $code, 'email' => $email, 'new' => $new]);
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
