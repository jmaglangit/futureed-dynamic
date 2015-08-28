<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


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
}