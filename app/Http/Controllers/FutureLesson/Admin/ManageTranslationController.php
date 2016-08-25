<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ManageTranslationController extends Controller {

	public function index(){
		return view('admin.manage.localization.index');
	}

	public function translation(){
		return view('admin.manage.localization.translations');
	}

	public function settings(){
		return view('admin.manage.localization.settings');
	}

	public function settings_main(){
		return view('admin.manage.localization.partials.main_settings');
	}
}
