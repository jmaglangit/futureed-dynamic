<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageQuestionTempController extends Controller {

	protected $admin_question_template = 'admin.manage.question_template.partials.';

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
		return view($this->admin_question_template . 'add_question_template');
	}

	/**
	 * @return view question template
	 */
	public function view_question_template()
	{
		return view($this->admin_question_template . 'view_question_template');
	}

	/**
	 * @return list of question template
	 */
	public function list_question_template()
	{
		return view($this->admin_question_template . 'list_question_template');
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function question_template_variable(){
		return view($this->admin_question_template . 'question_template_variable');
	}

}
