<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageParentPaymentController extends Controller{
	/**
	*@return Payment index
	*/
	public function index()
	{
		return view('client.parent.payment.index');
	}

	/**
	*@return Add Payment form
	*/
	public function add_payment_form()
	{
		return view('client.parent.payment.partials.add_payment_form');
	}

	/**
	*@return Payment form
	*/
	public function payment_form()
	{
		return view('client.parent.payment.partials.payment_form');
	}

	/**
	*@return View Payment form
	*/
	public function view_payment_form()
	{
		return view('client.parent.payment.partials.view_payment_form');
	}
}