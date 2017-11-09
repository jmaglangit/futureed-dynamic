<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageClassController extends Controller{
	/**
	*@return Class view
	*/
	public function index()
	{
		return view('client.teacher.class.index', ['active' => 'class']);
	}

	/**
	*@return Class view list
	*/
	public function list_class_form()
	{
		return view('client.teacher.class.partials.list_class_form');
	}

	/**
	*@return Class view
	*/
	public function view_class_form()
	{
		return view('client.teacher.class.partials.view_class_form');
	}

	/**
	*@return Class edit
	*/
	public function edit_class_form()
	{
		return view('client.teacher.class.partials.edit_class_form');
	}

	/**
	*@return add student 
	*/
	
	public function add_student_form()
	{
		return view('client.teacher.class.partials.add_student_form');
	}
}