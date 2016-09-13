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

	public function module(){
		return view('admin.manage.localization.partials.module');
	}

	public function question(){
		return view('admin.manage.localization.partials.question');
	}

	public function question_answer(){
		return view('admin.manage.localization.partials.question_answer');
	}

	public function answer_explanation(){
		return view('admin.manage.localization.partials.answer_explanation');
	}

	public function quote(){
		return view('admin.manage.localization.partials.quote');
	}
}
