<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageParentInvoiceController extends Controller{
	/**
	* @return Invoice Index
	*/
	public function index()
	{
		return view('client.parent.invoice.index');
	}

	/**
	* @return Invoice form 
	*/
	public function invoice_form()
	{
		return view('client.parent.invoice.partials.invoice_form');
	}
}