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
	 * Process session
	 *
	 * @return Response
	 */
	public function process()
	{
		return redirect()->route('student.dashboard.index');
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
		$input = Input::only('response', 'email');
		$response = $input['response'];
		$email = $input['email'];

		if($response == null && $email == null) {
			return redirect()->route('student.login.forgot_password');
		}

		return view('student.login.forgot-password-success', ['response' => $response, 'email' => $email]);
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
		$input = Input::only('id', 'code');
		$id = $input['id'];
		$code = $input['code'];

		// if($id == null || $code == null) {
			// return redirect()->route('student.login.forgot_password');
		// }

		return view('student.login.reset-password', ['id' => $id, 'code' => $code]);
	}
	
	/**
	 * Display reset confirm password screen
	 *
	 * @return Response
	 */
	public function reset_confirm_password()
	{
		$input = Input::only('student_id', 'reset_code', 'selected_image_id');

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
