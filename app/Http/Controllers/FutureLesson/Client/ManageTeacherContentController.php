<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageTeacherContentController extends Controller{
	/**
	*@return Teaching Content Index
	*/
	public function index() {
		return view('client.teacher.teaching_content.index');
	}

	/**
	*@return Teaching Content List
	*/
	public function list_content_form() {
		return view('client.teacher.teaching_content.partials.list_content_form');
	}
}