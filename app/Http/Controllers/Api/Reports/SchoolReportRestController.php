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

    /**
     * @param $school_code
     * @param $grade_level
     * @return mixed
     */
    public function schoolTeacherSubjectProgress($school_code, $grade_level){

        $report = $this->school_report->getSchoolTeacherSubjectProgress($school_code, $grade_level);

        return $this->respondReportData(
            $report['additional_information'],
            $report['column_header'],
            $report['rows']
        );

    }

    /**
     * @param $school_code
     * @param $grade_level
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function schoolTeacherSubjectScores($school_code, $grade_level) {

        $report = $this->school_report->getSchoolTeacherSubjectScores($school_code, $grade_level);

        return $this->respondReportData(
            $report['additional_information'],
            $report['column_header'],
            $report['rows']
        );

    }

    /**
     * @param $school_code
     * @param $teacher_id
     * @param $subject_id
     * @param $grade_level
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function schoolStudentSubjectProgress($school_code, $teacher_id, $subject_id, $grade_level){

        $report = $this->school_report
            ->getSchoolStudentSubjectProgress($school_code, $teacher_id, $subject_id, $grade_level);

        return $this->respondReportData(
            $report['additional_information'],
            $report['column_header'],
            $report['rows']
        );

    }

    /**
     * @param $school_code
     * @param $teacher_id
     * @param $subject_id
     * @param $grade_level
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function schoolStudentSubjectScores($school_code, $teacher_id, $subject_id, $grade_level){

        $report = $this->school_report
            ->getSchoolStudentSubjectScores($school_code, $teacher_id, $subject_id, $grade_level);

        return $report;

//        return $this->respondReportData(
//            $report['additional_information'],
//            $report['column_header'],
//            $report['rows']
//        );

    }

}
