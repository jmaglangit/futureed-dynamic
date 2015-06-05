<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageParentStudentController extends Controller{
	/**
	*@return Student View
	*/
	public function index()
	{
		return view('client.parent.student.index');
	}
}