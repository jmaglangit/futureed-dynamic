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

	public function coding_module() {
		return view('student.class.module.partials.questions.coding-module');
	}

	//For trial module
	public function trial_module()
	{
		return view('student.class.module.module-index-trial');
	}

	public function trial_module_question_list()
	{
		return view('student.class.module.partials.questions.trial-question-list');
	}

	public function notepad(){
		return view('student.class.module.partials.notepad');
	}

	public function fib(){
		return view('student.class.module.partials.questions.dynamic.fill-in-blanks');
	}

	public function steps($steps = 0){
		$steps = 3;
		return view('student.class.module.partials.questions.dynamic.answer-steps')->with('steps',$steps);
	}
}