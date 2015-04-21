<?php namespace FutureEd\Http\Controllers\FutureLesson\Error;

use FutureEd\Http\Controllers\Controller;

class ErrorsController extends Controller {

	public function error_404() {
		return view('errors.404');
	}

	public function error_405() {
		return view('errors.405');
	}

	public function error_500() {
		return view('errors.500');
	}
}