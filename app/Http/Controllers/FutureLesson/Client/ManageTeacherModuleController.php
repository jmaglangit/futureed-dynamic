<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageTeacherModuleController extends Controller{
	/**
	*@return Module Index View
	*/
	public function index() {
		return view('client.teacher.module.index');
	}

	/**
	*@return Module List View
	*/
	public function list_module_form() {
		return view('client.teacher.module.partials.list_module_form');
	}

	/**
	*@return Module View
	*/
	public function view_module() {
		return view('client.teacher.module.partials.view_module');
	}
}