<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class LoginController extends Controller{
	public function index(){
		return view('admin.login.login');
	}

	public function forgotPass(){
		$input = Input::only('email');
		if($input['email']) {
			return view('admin.login.enter-reset-code', ['email' => $input['email']]);
		}
		return view('admin.login.forgot-password', ['email' => $input['email']]);
	}
	/*POST method*/
	public function resetPass(){
		/*commented this so that reset password template can be viewed*/
		// $input = Input::only('id', 'reset_code');
		// $id = $input['id'];
		// $reset = $input['reset_code'];

		// if($id == null || $reset_code == null){
		// 	return redirect()->route('admin.login.forgot-password');
		// }
		// return view('admin.login.reset-password', ['id' => $id, 'reset_code' => $reset_code]);

		/*for viewing template only. remove this if reset pass is functional*/

		return view('admin.login.reset-password');
	}
}