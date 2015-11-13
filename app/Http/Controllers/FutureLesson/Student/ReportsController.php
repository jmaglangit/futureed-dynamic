<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ReportsController extends Controller {

	public function index(){
		return view('student.reports.index');
	}

	public function reports_form() {
		return view('student.reports.partials.reports_form');
	}
}
