<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageStudentController extends Controller{
	/**
	*@return Student Index
	*/
	public function index()
	{
		return view('admin.manage.student.index');
	}

	/**
	*@return List Student Form
	*/
	public function list_student_form()
	{
		return view('admin.manage.student.partials.list_student_form');
	}
}