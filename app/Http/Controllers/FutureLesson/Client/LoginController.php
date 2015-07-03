<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use FutureEd\Http\Controllers\FutureLesson\Traits\ProfileTrait;
use Illuminate\Http\Request;

class LoginController extends Controller {

	use ProfileTrait;

	/**
	 * Display login screen
	 *
	 * @return Response
	 */
	public function index()
	{
		$session = json_decode(Session::get('client'));

		if($session && $session->id) {
			return redirect()->route('client.dashboard.index');
		}

		return view('client.login.login');
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
			Session::forget('client');
			Session::forget($user_object->role);

			Session::put('client', $user_data['user_data']);
			Session::put($user_object->role, $user_data['user_data']);

			return redirect()->route('client.dashboard.index');
		}

		return redirect()->route('client.login');
	}

	/**
	 * Logout
	 *
	 * @return Response
	 */
	public function logout()
	{
		$user_object = json_decode(Session::get('client'));

		Session::forget('client');
		Session::forget($user_object->role);

		unset($user_object);

		return redirect()->route('client.login');
	}
	
	/**
	 * Display forgot password screen
	 *
	 * @return Response
	 */
	public function forgot_password()
	{
		$input = Input::only('email');

		if($input['email']) {
			return view('client.login.enter-reset-code', ['email' => $input['email']]);
		}

		return view('client.login.forgot-password', ['email' => $input['email']]);
	}

	/**
	 * Display registration screen
	 *
	 * @return Response
	 */
	public function registration($id = null)
	{
		return view('client.login.registration');
	}

	public function registration_invite($id = null)
	{
		$input = Input::only('registration_token');

		if($id && $input['registration_token']) {
			return view('client.login.registration-invite-form', array('id' => $id, 'registration_token' => $input['registration_token']));
		}

		return redirect()->route('client.registration');
	}

	public function registration_form() {

		return view('client.login.registration-form');
	}

	public function registration_success() {

		return view('client.login.registration-success');
	}

	public function enter_confirmation() {
		$input = Input::only('email');

		return view('client.login.enter-confirmation-code', ['email' => $input['email']]);
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

		return view('client.login.reset-password', array('id' => $id, 'reset_code' => $reset_code));
	}

	public function user_confirm() {
		$input = Input::only('email');

		return view('client.login.set-password', array('email' => $input['email']));
	}

	/**
	* Partials for AngularJS Directive
	*/

	public function base_url() {

		return view('client.partials.base-url');
	}

	public function terms()
	{
		return view('client.login.terms-and-conditions');
	}
}
