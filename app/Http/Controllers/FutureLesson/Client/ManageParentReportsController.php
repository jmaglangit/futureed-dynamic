<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageParentReportsController extends Controller{
	
	public function progress_bar() {
		return view('client.parent.dashboard.partials.reports_progress_bar');
	}

	public function report_card() {
		return view('client.parent.dashboard.partials.reports_report_card');
	}

	public function summary_progress() {
		return view('client.parent.dashboard.partials.reports_summary_progress');
	}

	public function subject_area() {
		return view('client.parent.dashboard.partials.reports_subject_area');
	}

	public function current_learning() {
		return view('client.parent.dashboard.partials.reports_current_learning');
	}

}