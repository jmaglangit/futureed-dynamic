<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;

class ClassModuleController extends Controller {
	/**
	*Display Module Index Page
	*/
	public function index() {
		return view('student.class.module.index');
	}

	/**
	*Display Modules
	*/
	public function module() {
		return view('student.class.module.index');
	}

	/**
	*Display Add Help
	*/
	public function add_help() {
		return view('student.class.module.partials.add_help');
	}

	/**
	*Display List Help
	*/
	public function list_help() {
		return view('student.class.module.partials.list_help');
	}

	/**
	*Display Current Help
	*/
	public function current_help() {
		return view('student.class.module.partials.current_help');
	}

	/**
	*Display Current View Help
	*/
	public function current_view_help() {
		return view('student.class.module.partials.current_view_help');
	}
}