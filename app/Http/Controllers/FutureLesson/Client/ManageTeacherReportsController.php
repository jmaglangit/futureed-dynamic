<?php namespace FutureEd\Http\Controllers\FutureLesson\Client;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class ManageTeacherReportsController extends Controller{

	public function index(){
		return view('client.teacher.reports.index');
	}

	public function reports_form() {
		return view('client.teacher.reports.partials.reports_form');
	}

	public function report_card() {
		return view('client.teacher.reports.partials.report_card_form');
	}

	public function subject_area() {
		return view('client.teacher.reports.partials.subject_area_form');
	}

	public function subject_area_heatmap(){
		return view('client.teacher.reports.partials.subject_area_heatmap_form');
	}

	public function summary_progress() {
		return view('client.teacher.reports.partials.summary_progress_form');
	}

	public function current_learning() {
		return view('client.teacher.reports.partials.current_learning_form');
	}

	public function progress_bar(){
		return view('client.teacher.reports.partials.progress_bar');
	}

	public function question_analysis(){
		return view('client.teacher.reports.partials.question_analysis');
	}

	public function platform_chart_monthly(){
		return view('client.teacher.reports.partials.charts.platform-chart-monthly');
	}

	public function platform_chart_weekly(){
		return view('client.teacher.reports.partials.charts.platform-chart-weekly');
	}

	public function platform_chart_subject_area(){
		return view('client.teacher.reports.partials.charts.platform-chart-subject-area');
	}

	public function platform_chart_subject_area_heatmap(){
		return view('client.teacher.reports.partials.charts.platform-chart-subject-area-heatmap');
	}
}