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
		} else if(Session::get('client')) {

			return redirect()->route('client.dashboard.index');
		}

		return view('student.login.index', ['id' => null]);
	}

	public function post_index()
	{
		$input = Input::only('id');
		if(!isset($input['id']) || !is_numeric($input['id'])) {
			abort(404);
		}
		
		return view('student.login.index', ['id' => $input['id']]);
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
		$user_object = json_decode(Session::get('student'));

		Session::forget('student');

		if(isset($user_object->impersonate)) {
			return redirect()->route('admin.manage.student.index');
		}

		return redirect()->route('student.login');
	}
	
	/**
	 * Display forgot password screen
	 *
	 * @return Response
	 */
	public function forgot_password()
	{
		$input = Input::only('email');
		return view('student.login.password.index')->with(array('email' => $input['email']));
	}

	/**
	* Display enter reset code screen
	*
	* @return Response
	*/
	public function enter_reset_code() 
	{
		return view('student.login.password.enter-reset-code');
	}

	/**
	 * Display registration screen
	 *
	 * @return Response
	 */
	public function registration()
	{
		$input = Input::only('email','code');
		$invitation  = Input::only('registration_token', 'id');

		if($invitation['id'] && $invitation['registration_token']){
			return view('student.login.registration', [
				'email' => null,
				'id' => $invitation['id'],
				'registration_token' => $invitation['registration_token'
				]]);
		}
		else{
			return view('student.login.registration', [
				'email' => $input['email'],
				'code' => $input['code'],
				'id' => null,
				'registration_token' => null]);
		}
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
			return redirect()->route('student.login.forgot_password');
		}

		return view('student.login.reset-password', ['id' => $id, 'reset_code' => $reset_code]);
	}

	public function set_password() {
		$input = Input::only('id');
		$id = $input['id'];

		if($id == null) {
			return redirect()->route('student.registration');
		}

		return view('student.login.set-password', ['id' => $id]);
	}

	/**
	* Partials for AngularJS Directive
	*/

	public function base_url() {

		return view('student.partials.base-url');
	}

	public function tips_help_bar() {
		return view('student.partials.tips-help-bar');
	}	

	public function confirm_media() {
		return view('student.login.partials.confirm-media');
	}

	public function enter_password() {
		return view('student.login.partials.enter-password');
	}

	public function index_form() {
		return view('student.login.partials.login');
	}

	public function registration_form() {
		return view('student.login.register.registration-form');
	}

	public function registration_success() {
		return view('student.login.register.registration-success');
	}

	public function privacy_policy(){
		return view('student.login.privacy-policy');
	}

	public function resend_confirmation(){
		return view('student.login.register.registration-resend-confirmation');
	}
}
