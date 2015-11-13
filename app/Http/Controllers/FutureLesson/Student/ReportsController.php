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

	public function report_card() {
		return view('student.reports.partials.report_card_form');
	}

	public function subject_area() {
		return view('student.reports.partials.subject_area_form');
	}

	public function summary_progress() {
		return view('student.reports.partials.summary_progress_form');
	}

	public function current_learning() {
		return view('student.reports.partials.current_learning_form');
	}

	public function progress_bar(){
		return view('student.reports.partials.progress_bar');
	}
}
