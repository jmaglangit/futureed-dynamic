<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageTeacherTipsController extends Controller{
	/**
	*@return Index Tips
	*/
	public function index(){
		return view('client.teacher.tips.index');
	}

	/**
	*@return Index Tips
	*/
	public function list_tips_form(){
		return view('client.teacher.tips.partials.list');
	}

	/**
	*@return View Tips
	*/
	public function view_tips_form(){
		return view('client.teacher.tips.partials.view');
	}	
}