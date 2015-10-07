<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Controllers\Controller;

class AdminLogsController extends Controller {

	/**
	* @return announcement index view
	*/
	public function index() {
		return view('admin.manage.logs.index');
	}

	public function list_form() {
		return view('admin.manage.logs.partials.list');
	}
}