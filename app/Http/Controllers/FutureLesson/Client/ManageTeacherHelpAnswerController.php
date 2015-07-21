<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageTeacherHelpAnswerController extends Controller{
	/**
	*@return List View
	*/
	public function list_help_ans_form() {
		return view('client.teacher.help_answer.partials.list_help_ans_form');
	}

	/**
	*@return Edit & View Form
	*/
	public function view_help_ans_form() {
		return view('client.teacher.help_answer.partials.view_help_ans_form');
	}
}