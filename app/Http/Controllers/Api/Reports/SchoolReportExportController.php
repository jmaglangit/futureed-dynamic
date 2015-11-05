<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

class SchoolReportExportController extends ReportController {

	protected $school_report;

	public function __construct(
		SchoolReportController $schoolReportController
	) {
		$this->school_report = $schoolReportController;
	}

	/**
	 * Get School Progress by school_code and file type
	 * @param $school_code
	 * @param $file_type
	 * @return mixed
	 * @internal param $file
	 */
	public function schoolProgress($school_code, $file_type){

		$report = $this->school_report->getSchoolProgress($school_code);

		// Template to export

		return Excel::create('SchoolProgress')->export($file_type);
	}

	/**
	 * @param $school_code
	 * @param $file_type
	 * @return mixed
	 */
	public function schoolTeacherProgress($school_code,$file_type){

		$report = $this->school_report->getSchoolTeacherProgress($school_code);

		return Excel::create('SchoolTeacherProgress')->export($file_type);
	}

}
