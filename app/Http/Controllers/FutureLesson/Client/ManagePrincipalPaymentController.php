<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManagePrincipalPaymentController extends Controller{

	/**
	* @return Principal Payment View Index
	*/
	public function index()
	{
		return view('client.principal.payment.index', ['active' => 'payment']);
	}

	/**
	* @return Principal Payment Partial Payment Form
	*/
	public function payment_form() 
	{
		return view('client.principal.payment.partials.payment_form');
	}

	/**
	* @return Principal Payment Partial Payment Form
	*/
	public function add_payment_form() 
	{
		return view('client.principal.payment.partials.add_payment_form');
	}

	/**
	* @return Principal View Partial Payment Form
	*/
	public function view_payment_form() 
	{
		return view('client.principal.payment.partials.view_payment_details');
	}

	public function payment_success() 
	{
		$input = Input::only('token', 'paymentId');

		if(!($input['token'] || $input['paymentId'])) {
			return redirect()->route('client.principal.payment.index');
		}

		return view('client.partials.success_payment');
	}

	public function payment_fail() 
	{
		$input = Input::only('token');

		if(!$input['token']) {
			return redirect()->route('client.principal.payment.index');
		}

		return view('client.partials.fail_payment');
	}

	public function subscription(){
		return view('client.principal.payment.partials.subscribe');
	}

	public function invoice_header(){
		return view('client.principal.payment.partials.invoice_header');
	}

	public function invoice_footer(){
		return view('client.principal.payment.partials.invoice_footer');
	}
}