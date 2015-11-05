<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SchoolReportRestController extends ReportController {

	protected $school_report;

	public function __construct(
		SchoolReportController $schoolReportController
	) {
		$this->school_report = $schoolReportController;
	}

	/**
	 * Get School Progress by school_code and file type
	 * @param $school_code
	 * @return mixed
	 * @internal param $file_type
	 * @internal param $file
	 */
	public function schoolProgress($school_code){

		$report = $this->school_report->getSchoolProgress($school_code);

		return $this->respondReportData(
			$report['additional_information'],
			$report['column_header'],
			$report['rows']
		);
	}

	/**
	 * @param $school_code
	 * @param $file_type
	 * @return mixed
	 */
	public function schoolTeacherProgress($school_code){

		$report = $this->school_report->getSchoolTeacherProgress($school_code);

		return $this->respondReportData(
			$report['additional_information'],
			$report['column_header'],
			$report['rows']
		);
	}

}
