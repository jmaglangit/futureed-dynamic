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

	/**
	* Partial subscription
	* @return view
	*/
	public function subscription(){
		return view('admin.manage.price.partials.subscription');
	}

	/**
	 * Partial subscription days
	 * @return \Illuminate\View\View
	 */
	public function subscription_days(){
		return view('admin.manage.price.partials.subscription_days');
	}

	/**
	 * Partial subscription packages
	 * @return \Illuminate\View\View
	 */
	public function subscription_packages(){
		return view('admin.manage.price.partials.subscription_packages');
	}

	/**
	* Partial client discount
	* @return view
	*/
	public function client_discount(){
		return view('admin.manage.price.partials.client_discount');
	}

	/**
	* Partial client edit price
	* @return view
	*/
	public function edit_price(){
		return view('admin.manage.price.partials.edit_price');
	}

	/**
	* Partial client bulk discount
	* @return view
	*/
	public function bulk_discount(){
		return view('admin.manage.price.partials.bulk_discount');
	}

	/**
	* Partial client bulk discount edit
	* @return view
	*/
	public function bulk_edit(){
		return view('admin.manage.price.partials.edit_bulk');
	}
}