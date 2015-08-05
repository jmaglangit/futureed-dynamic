<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class TipsController extends Controller {

	public function index()
	{
		$input = Input::only('id');
		
		$input['id'] = ($input['id']) ? $input['id'] : '';

		return view('student.tips.index', $input);
	}

	public function list_form()
	{	
		return view('student.tips.partials.list');
	}

	public function detail_form()
	{	
		return view('student.tips.partials.detail');
	}

	/**
	*Display Add Tip
	*/
	public function add_tip() {
		return view('student.class.module.partials.tips.add');
	}

	/**
	*Display List Tip
	*/
	public function list_tips() {
		return view('student.class.module.partials.tips.list');
	}

	public function view_tip() {
		return view('student.class.module.partials.tips.view');
	}
}