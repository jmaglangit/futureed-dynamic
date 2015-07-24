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

	/**
	*Display Your Help
	*/
	public function list_your_help() {
		return view('student.class.module.partials.list_your_help');
	}

	/**
	*Display Own Help
	*/
	public function view_your_help() {
		return view('student.class.module.partials.view_your_help');
	}

	/**
	*Display Add Tip
	*/
	public function add_tip() {
		return view('student.class.module.partials.add_tip');
	}

	/**
	*Display List Tip
	*/
	public function list_tips() {
		return view('student.class.module.partials.list_tips');
	}

	/**
	*Display List Current Tip
	*/
	public function list_current_tips() {
		return view('student.class.module.partials.list_current_tips');
	}

	/**
	*Display List All Tip
	*/
	public function list_all_tips() {
		return view('student.class.module.partials.list_all_tips');
	}

	/**
	*Display View Current Tip
	*/
	public function view_current_tips() {
		return view('student.class.module.partials.view_current_tips');
	}

	/**
	*Display View All Tip
	*/
	public function view_all_tips() {
		return view('student.class.module.partials.view_all_tips');
	}
}