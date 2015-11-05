<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

class ClassReportExportController extends ReportController {

	protected $class_report;

	public function __construct(
		ClassReportController $classReportController
	) {
		$this->class_report = $classReportController;
	}

	public function classReport($class_id, $file_type){

		$report = $this->class_report->getClassReport($class_id);

		// Create export template

		return Excel::create('ClassReport')->export($file_type);

	}

}
