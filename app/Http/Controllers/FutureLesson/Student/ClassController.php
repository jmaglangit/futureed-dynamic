<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;

class ClassController extends Controller {
	/**
	*Display Class Index Page
	*/
	public function index() {
		return view('student.class.index');
	}

	/**
	*Display Class Side Nave Page
	*/
	public function dashbrd_side_nav() {
		return view('student.class.partials.dashbrd-side-nav');
	}

	/**
	*Display List of Modules
	*/
	public function module_list() {
		return view('student.class.partials.module_list');
	}

}