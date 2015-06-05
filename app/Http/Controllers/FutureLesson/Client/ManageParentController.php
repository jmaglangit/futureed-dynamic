<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageParentController extends Controller{
	/**
	*@return Parent View
	*/
	public function index()
	{
		return view('client.parent.index');
	}
}