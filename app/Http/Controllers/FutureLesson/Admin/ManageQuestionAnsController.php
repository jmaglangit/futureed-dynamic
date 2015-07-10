<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageQuestionAnsController extends Controller{
	/**
	*@return List View Form
	*/
	public function question_list_form() {
		return view('admin.manage.question_answer.partials.question_list_form');
	}

	/**
	*@return add View Form
	*/
	public function question_add_form() {
		return view('admin.manage.question_answer.partials.question_add_form');
	}
}