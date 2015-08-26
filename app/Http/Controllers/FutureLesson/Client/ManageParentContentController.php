<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageParentContentController extends Controller{
	/**
	*@return Parent Content Index
	*/
	public function index() {
		return view('client.parent.teaching_content.index',['active' => 'module']);
	}

	/**
	*@return Parent Content List
	*/
	public function list_content_form() {
		return view('client.parent.teaching_content.partials.list_content_form');
	}
}