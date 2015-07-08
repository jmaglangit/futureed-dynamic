<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageModuleController extends Controller{
	/**
	*@return index view form
	*/
	public function index() {
		return view('admin.manage.module.index');
	}

	/**
	*@return list view form
	*/
	public function list_module_form() {
		return view('admin.manage.module.partials.list_module_form');
	}

	/**
	*@return add view form
	*/
	public function add_module_form() {
		return view('admin.manage.module.partials.add_module_form');
	}

	/**
	*@return view form
	*/
	public function view_module_form() {
		return view('admin.manage.module.partials.view_module_form');
	}
}
