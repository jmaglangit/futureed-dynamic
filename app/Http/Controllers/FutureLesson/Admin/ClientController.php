<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ClientController extends Controller{

	/**
	* Manage Client Index
	*/
	public function index() {
		return view('admin.manage.client.index');
	}

	/**
	* Manage Client Side Nav
	*/
	public function side_nav() {
		return view('admin.manage.client.partials.client_side_nav');
	}

	/**
	* List / Search Client
	*/
	public function list_client_form() {
		return view('admin.manage.client.partials.list_client_form');
	}

	/**
	* Add Client Form
	*/
	public function add_client_form() {
		return view('admin.manage.client.partials.add_client_form');
	}

	/**
	* Edit Client Email 
	*/
	public function edit_email_form() {
		return view('admin.manage.client.partials.edit_email_form');
	}

	/**
	* Confirm Edit Client Email
	*/
	public function confirm_email_form() {
		return view('admin.manage.client.partials.confirm_email_form');
	}

	/**
	* View / Edit Client Profile
	*/
	public function detail_form() {
		return view('admin.manage.client.partials.detail_form');
	}
	
}