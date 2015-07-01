<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageHelpRequestController extends Controller{

	public function index() {
		return view('admin.manage.help.index');
	}

	public function list_form() {
		return view('admin.manage.help.partials.list');
	}

	public function detail_form() {
		return view('admin.manage.help.partials.detail');
	}
}	