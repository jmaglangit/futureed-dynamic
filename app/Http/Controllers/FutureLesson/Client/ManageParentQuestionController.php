<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageParentQuestionController extends Controller{
	/**
	*@return Question Index
	*/
	public function index() {
		return view('client.parent.question.index',['active' => 'module']);
	}

	/**
	*@return Question list
	*/
	public function listview() {
		return view('client.parent.question.partials.list');
	}
}