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