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

	/**
	*@return Student View
	*/
	public function list_student_form()
	{
		return view('client.parent.student.partials.list_student_form');
	}

	/**
	*@return Student Add
	*/
	public function add_student_form()
	{
		return view('client.parent.student.partials.add_student_form');
	}

	/**
	*@return Student View/Edit
	*/
	public function view_student_form()
	{
		return view('client.parent.student.partials.view_student_form');
	}

	/**
	*@return Student Invitation Page
	*/
	public function invitation_code_form()
	{
		return view('client.parent.student.partials.invitation_code_form');
	}
}