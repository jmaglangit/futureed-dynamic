<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class HelpController extends Controller {

	public function index()
	{
		$input = Input::only('request_type');
		$input['request_type'] = ($input['request_type']) ? $input['request_type'] : 'All';
		
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
}