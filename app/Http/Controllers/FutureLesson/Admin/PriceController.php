<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class PriceController extends Controller{

	/**
	* Manage Price Index
	* @return price index view
	*/
	public function index(){
		return view('admin.manage.price.index',['active' => 'price']);
	}
}