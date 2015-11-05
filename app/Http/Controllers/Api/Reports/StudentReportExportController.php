<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentReportExportController extends ReportController {

	protected $student_report;

	public function __construct(
		StudentReportController $studentReportController
	) {
		$this->student_report = $studentReportController;
	}

	public function studentStatusReport($student_id, $file_type){

		$report = $this->student_report->getStudentStatusReport($student_id);

		return Excel::create('StudentStatusReport')->export($file_type);

	}

	public function studentProgressReport($student_id, $subject_id, $file_type){

		$report = $this->student_report->getStudentProgressReport($student_id,$subject_id);

		return Excel::create('filename')->export($file_type);
	}

	public function studentSubjectGradeProgressReport($student_id,$subject_id,$file_type){

		$report = $this->student_report->getStudentSubjectGradeProgressReport($student_id,$subject_id);

		return Excel::create('filename')->export($file_type);
	}

	public function studentCurrentLearning($student_id, $subject_id, $file_type){

		$report = $this->student_report->getStudentCurrentLearning($student_id,$subject_id);

		return Excel::create('filename')->export($file_type);
	}

}
