<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;

class ClassReportRestController extends ReportController {

	protected $class_report;

	public function __construct(
		ClassReportController $classReportController
	) {

		$this->class_report = $classReportController;
	}

	/**
	 * Class dashboard for front-end.
	 * @param $class_id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function classReport($class_id){

		$report = $this->class_report->getClassReport($class_id);

		return $this->respondReportData(
			$report['additional_information'],
			$report['column_header'],
			$report['rows']
		);
	}

}
