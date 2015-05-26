<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageSubjectController extends Controller{

	public function index() {
		return view('admin.manage.subject.index');
	}

	public function subject_list_form() {
		return view('admin.manage.subject.partials.subject_list_form');
	}

	public function add_subject_form() {
		return view('admin.manage.subject.partials.add_subject_form');
	}

	public function subject_details_form() {
		return view('admin.manage.subject.partials.subject_details_form');
	}

	public function delete_subject_form() {
		return view('admin.manage.subject.partials.delete_subject_form');
	}

	public function subject_side_nav() {
		return view('admin.manage.subject.partials.subject_side_nav');
	}
}