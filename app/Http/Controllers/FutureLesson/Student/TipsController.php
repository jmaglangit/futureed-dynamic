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
}