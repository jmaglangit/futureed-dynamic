<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;

class StudentReportRestController extends ReportController {

	/**
	 * @var StudentReportController
	 */
	protected $student_report;

	/**
	 * StudentReportRestController constructor.
	 * @param StudentReportController $studentReportController
	 */
	public function __construct(
		StudentReportController $studentReportController
	) {
		$this->student_report = $studentReportController;
	}

	/**
	 * @param $student_id
	 * @param $file_type
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function studentStatusReport($student_id){

		$report = $this->student_report->getStudentStatusReport($student_id);

		return $this->respondReportData(
			$report['additional_information'],
			$report['column_header'],
			$report['rows']
		);

	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function studentProgressReport($student_id, $subject_id){

		$report = $this->student_report->getStudentProgressReport($student_id,$subject_id);

		return $this->respondReportData(
			$report['additional_information'],
			$report['column_header'],
			$report['rows']
		);
	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function studentSubjectGradeProgressReport($student_id, $subject_id){

		$report = $this->student_report->getStudentSubjectGradeProgressReport($student_id,$subject_id);

		return $this->respondReportData(
			$report['additional_information'],
			$report['column_header'],
			$report['rows']
		);
	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function studentCurrentLearning($student_id, $subject_id){

		$report = $this->student_report->getStudentCurrentLearning($student_id,$subject_id);

		return $this->respondReportData(
			$report['additional_information'],
			$report['column_header'],
			$report['rows']
		);
	}

}
