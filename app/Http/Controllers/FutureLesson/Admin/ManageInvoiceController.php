<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageInvoiceController extends Controller{
	
	/**
	* @return Invoice Index view
	*/
	public function index()
	{
		return view('admin.manage.invoice.index');
	}

	/**
	* @return Invoice list view
	*/
	public function invoice_list()
	{
		return view('admin.manage.invoice.partials.invoice_list');
	}

	/**
	* @return Invoice list view
	*/
	public function view_invoice()
	{
		return view('admin.manage.invoice.partials.view_invoice');
	}
}