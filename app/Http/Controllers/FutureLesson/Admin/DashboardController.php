<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class DashboardController extends Controller{
	public function index(){
		return view('admin.dashboard.index',['active' => 'client']);
	}

	public function add_client(){
		return view('admin.manage.client.add_client', ['sub-active' => 'add_client', 'active' => 'client']);
	}

	public function client_list(){
		return view('admin.dashboard.client_list');
	}

	public function announcement(){
		return view('admin.manage.announcement');
	}
}