<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageTeacherStudentController extends Controller{
	/**
	*@return Student index
	*/
	public function index()
	{
		return view('client.teacher.student.index',['active' => 'teacher']);
	}

	/**
	*@return Student list
	*/
	public function list_student_form()
	{
		return view('client.teacher.student.partials.list_student_form');
	}

	/**
	*@return Student view/edit
	*/
	public function view_student_form()
	{
		return view('client.teacher.student.partials.view_student_form');
	}

	/**
	*@return Student view/edit
	*/
	public function email_student_form()
	{
		return view('client.teacher.student.partials.email_student_form');
	}
}