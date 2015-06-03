<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageTeacherController extends Controller{

	/**
	* @return teacher index view
	*/
	public function index()
	{
		return view('client.teacher.index');
	}

	/**
	* @return partial teacher list view
	*/
	public function list_teacher_form()
	{
		return view('client.teacher.partials.list_teacher_form');
	}

	/**
	* @return partial teacher add view
	*/
	public function add_teacher_form()
	{
		return view('client.teacher.partials.add_teacher_form');
	}

	/**
	* @return partial teacher view
	*/
	public function view_teacher_form()
	{
		return view('client.teacher.partials.view_teacher_form');
	}
}