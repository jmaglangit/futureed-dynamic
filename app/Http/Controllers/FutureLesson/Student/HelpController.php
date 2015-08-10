<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class HelpController extends Controller {

	public function index()
	{
		$input = Input::only('request_type', 'id');
		
		$input['request_type'] = ($input['request_type']) ? $input['request_type'] : '';
		$input['id'] = ($input['id']) ? $input['id'] : '';
		
		return view('student.help.index', $input);
	}
	
	public function list_form()
	{	
		return view('student.help.partials.list');
	}

	public function detail_form()
	{	
		return view('student.help.partials.detail');
	}

	/**
	*Display Add Help
	*/
	public function add_help() {
		return view('student.class.module.partials.help_request.add');
	}

	/**
	*Display List Help
	*/
	public function list_help() {
		return view('student.class.module.partials.help_request.list');
	}

	/**
	*Display Current Help
	*/
	public function view_help() {
		return view('student.class.module.partials.help_request.view');
	}
}