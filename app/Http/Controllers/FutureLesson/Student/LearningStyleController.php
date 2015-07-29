<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class LearningStyleController extends Controller {

	public function index() {
		return view('student.learning-style.index');
	}

}