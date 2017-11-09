<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageGradeController extends Controller {
	
	public function index() {
		return view('admin.manage.grades.index');
	}

	public function grade_list_form() {
		return view('admin.manage.grades.partials.grade_list_form');
	}

	public function add_grade_form() {
		return view('admin.manage.grades.partials.add_grade_form');
	}

	public function grade_details_form() {
		return view('admin.manage.grades.partials.grade_details_form');
	}

	public function delete_grade_form() {
		return view('admin.manage.grades.partials.delete_grade_form');
	}

	public function grade_side_nav() {
		return view('admin.manage.grades.partials.grade_side_nav');
	}
}