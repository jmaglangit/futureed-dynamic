<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;

class ClassModuleController extends Controller {
	/**
	*Display Module Index Page
	*/
	public function index($id = null) {
		return view('student.class.module.index')->with('id', $id);
	}

	/**
	*Display Modules
	*/
	public function module($id = null) {
		return view('student.class.module.index')->with('id', $id);
	}

	/**
	*Display Add Help
	*/
	public function add_help() {
		return view('student.class.module.partials.help_request.add_help');
	}

	/**
	*Display List Help
	*/
	public function list_help() {
		return view('student.class.module.partials.help_request.list_help');
	}

	/**
	*Display Current Help
	*/
	public function current_help() {
		return view('student.class.module.partials.help_request.current_help');
	}

	/**
	*Display Current View Help
	*/
	public function current_view_help() {
		return view('student.class.module.partials.help_request.current_view_help');
	}

	/**
	*Display Your Help
	*/
	public function list_your_help() {
		return view('student.class.module.partials.help_request.list_your_help');
	}

	/**
	*Display Own Help
	*/
	public function view_your_help() {
		return view('student.class.module.partials.help_request.view_your_help');
	}

	/**
	*Display List Current Tip
	*/
	public function list_current_tips() {
		return view('student.class.module.partials.tips.list_current_tips');
	}

	/**
	*Display List All Tip
	*/
	public function list_all_tips() {
		return view('student.class.module.partials.tips.list_all_tips');
	}

	/**
	*Display View Current Tip
	*/
	public function view_current_tips() {
		return view('student.class.module.partials.tips.view_current_tips');
	}

	/**
	*Display View All Tip
	*/
	public function view_all_tips() {
		return view('student.class.module.partials.tips.view_all_tips');
	}

	public function contents() {
		return view('student.class.module.partials.contents.list');
	}

	public function questions() {
		return view('student.class.module.partials.questions.list');
	}

	public function view_question_message() {
		return view('student.class.module.partials.questions.message');
	}
}