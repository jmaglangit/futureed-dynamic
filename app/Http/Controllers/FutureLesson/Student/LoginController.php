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
		if(Session::get('student')) {
			$user_object = json_decode(Session::get('student'));
			
			if(!isset($user_object->avatar_id)) {
				return redirect()->route('student.dashboard.follow_up_registration');
			}

			return redirect()->route('student.dashboard.index');
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
		$user_data = Input::only('user_data');
		$user_object = json_decode($user_data['user_data']);

		if($user_object->id){
			Session::forget('student');
			Session::put('student', $user_data['user_data']);

			if($user_object->avatar_id) {
				return redirect()->route('student.dashboard.index');
			}
			
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
		Session::forget('student');
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
		
		return view('student.login.enter-reset-code')->with(array('email' => $email, 'show' => $show));
	}

	/**
	 * Display registration screen
	 *
	 * @return Response
	 */
	public function registration()
	{
		$input = Input::only('email');
		$success = 0;

		if($input['email']) {
			$success = 1;
		}

		return view('student.login.registration', ['success' => $success, 'email' => $input['email']]);
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
	* Partials for AngularJS Directive
	*/

	public function base_url() {

		return view('student.partials.base-url');
	}
}
