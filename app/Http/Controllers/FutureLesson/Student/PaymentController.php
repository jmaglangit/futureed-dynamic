<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;


use Illuminate\Http\Request;

class PaymentController extends Controller {

	public function index() {
		$user = json_decode(Session::get('student'));
		
		if(intval($user->age) <= 13) {
			return redirect()->route('student.dashboard.index');
		}

		return view('student.payment.index');
	}

	public function list_form() {
		return view('student.payment.partials.list');
	}

	public function add_form() {
		return view('student.payment.partials.add');
	}

	public function view_form() {
		return view('student.payment.partials.view');
	}

	public function success() 
	{
		$input = Input::only('token', 'paymentId');

		if(!($input['token'] || $input['paymentId'])) {
			return redirect()->route('student.payment.index');
		}

		return view('student.payment.partials.success');
	}

	public function fail() 
	{
		$input = Input::only('token');

		if(!$input['token']) {
			return redirect()->route('student.payment.index');
		}

		return view('student.payment.partials.fail');
	}
}