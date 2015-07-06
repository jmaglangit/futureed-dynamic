<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;

class TipsController extends Controller {

	public function index()
	{
		return view('student.tips.index');
	}

	public function list_form()
	{	
		return view('student.tips.list');
	}

	public function detail_form()
	{	
		return view('student.tips.detail');
	}
}