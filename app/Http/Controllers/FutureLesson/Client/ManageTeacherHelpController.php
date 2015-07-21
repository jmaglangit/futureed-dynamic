<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageTeacherHelpController extends Controller{
	/**
	*@return Help Index
	*/	
	public function index(){
		return view('client.teacher.help.index');
	}

	/**
	*@return List Form
	*/	
	public function list_help_form(){
		return view('client.teacher.help.partials.list');
	}

	/**
	*@return View Form
	*/	
	public function view_help_form(){
		return view('client.teacher.help.partials.view');
	}
}