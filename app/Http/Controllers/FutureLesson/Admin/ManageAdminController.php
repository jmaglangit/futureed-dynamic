<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageAdminController extends Controller{

	public function index() {
		return view('admin.manage.admin.index');
	}

	public function side_nav() {
		return view('admin.manage.admin.partials.side_nav',['active' => 'admin']);
	}

	public function list_admin_form() {
		return view('admin.manage.admin.partials.list_admin_form');
	}

	public function add_admin() {
		return view('admin.manage.admin.partials.add_admin');
	}

	public function view_admin() {
		return view('admin.manage.admin.partials.view_admin');
	}

	public function reset_pass() {
		return view('admin.manage.admin.partials.reset_pass');
	}
}