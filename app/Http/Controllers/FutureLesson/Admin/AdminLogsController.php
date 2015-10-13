<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Controllers\Controller;

class AdminLogsController extends Controller {

	public function index() {
		return view('admin.manage.logs.index');
	}

	public function security_list_form() {
		return view('admin.manage.logs.partials.security-list');
	}

	public function admin_list_form() {
		return view('admin.manage.logs.partials.admin-list');
	}

	public function user_list_form() {
		return view('admin.manage.logs.partials.user-list');
	}

	public function system_list_form() {
		return view('admin.manage.logs.partials.system-list');
	}

	public function errors_list_form() {
		return view('admin.manage.logs.partials.errors-list');
	}
}