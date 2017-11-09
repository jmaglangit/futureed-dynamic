<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class AnnouncementController extends Controller{

	/**
	* @return announcement index view
	*/
	public function index()
	{
		return view('admin.manage.announcement.index', ['active' => 'announcement']);
	}
}