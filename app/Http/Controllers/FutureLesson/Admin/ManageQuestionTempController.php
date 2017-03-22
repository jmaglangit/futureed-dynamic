<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageQuestionTempController extends Controller {

	/**
	 * @return list of question template
	 */
	public function index()
	{
		return view('admin.manage.question_template.index');
	}

	/**
	 * @return add question template
	 */
	public function add_question_template()
	{
		return view('admin.manage.question_template.partials.add_question_template');
	}

	/**
	 * @return view question template
	 */
	public function view_question_template()
	{
		return view('admin.manage.question_template.partials.view_question_template');
	}

	/**
	 * @return list of question template
	 */
	public function list_question_template()
	{
		return view('admin.manage.question_template.partials.list_question_template');
	}

}
