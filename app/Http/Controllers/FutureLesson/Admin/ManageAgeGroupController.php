<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageAgeGroupController extends Controller{
	/**
	*@return list view form
	*/
	public function list_view_form() {
		return view('admin.manage.age_group.partials.list_view_form');
	}

	/**
	*@return add view form
	*/
	public function add_view_form() {
		return view('admin.manage.age_group.partials.add_view_form');
	}
}