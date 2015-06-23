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
		return view('client.principal.payment.index');
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
}