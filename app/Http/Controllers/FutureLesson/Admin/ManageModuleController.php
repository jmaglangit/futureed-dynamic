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

	/**
	* @return module questions preview
	*/
	public function module_questions_preview() {
		return view('admin.manage.module.partials.module_questions_preview');
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function module_question(){

		return view('admin.manage.module.module_questions')->with('module',Input::get('module'));
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function dynamic_setup(){
		return view('admin.manage.module.partials.dynamic_setup');
	}
}
