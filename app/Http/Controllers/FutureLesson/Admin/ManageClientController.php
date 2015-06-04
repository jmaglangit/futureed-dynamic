<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageClientController extends Controller{

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
	*
	*/
	public function client_details_form() {
		return view('admin.manage.client.partials.client_details_form');
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
	* Confirm delete Client Email
	*/
	public function delete_client_form() {
		return view('admin.manage.client.partials.delete_client_form');
	}

	/**
	* View / Edit Client Profile
	*/
	public function detail_form() {
		return view('admin.manage.client.partials.detail_form');
	}

	public function type_ahead_form() {
		return view('admin.manage.client.partials.type_ahead_form');
	}
	
}