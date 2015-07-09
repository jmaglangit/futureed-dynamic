<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageModuleContentController extends Controller{
	/**
	*@return index view form
	*/
	public function index() {
		return view('admin.manage.content.index');
	}

	/**
	*@return list view form
	*/
	public function list_form() {
		return view('admin.manage.content.partials.list');
	}

	/**
	*@return add view form
	*/
	public function add_form() {
		return view('admin.manage.content.partials.add');
	}

	/**
	*@return view form
	*/
	public function detail_form() {
		return view('admin.manage.content.partials.detail');
	}

	/**
	*@return de;ete form
	*/
	public function delete_form() {
		return view('admin.manage.content.partials.delete');
	}
}
