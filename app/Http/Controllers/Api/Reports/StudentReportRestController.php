<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Services\ImageServices;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class StudentReportRestController extends ReportController {

	/**
	 * @var StudentReportController
	 */
	protected $student_report;
	protected $image_service;

	/**
	 * StudentReportRestController constructor.
	 * @param StudentReportController $studentReportController
	 * @param ImageServices $imageServices
	 */
	public function __construct(
		StudentReportController $studentReportController,
		ImageServices $imageServices
	) {
		$this->student_report = $studentReportController;
		$this->image_service = $imageServices;
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
		$report = $this->image_service->getIconImageUrl($report);

		return $this->respondReportData(
			$report['additional_information'],
			$report['column_header'],
			$report['rows']
		);
	}

	/**
	 * Get student progress heat map for platforms.
	 * @param $student_id
	 * @param $subject_id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getSubjectAreaHeatMap($student_id,$subject_id){

		$report = $this->student_report->getSubjectAreaHeatMap($student_id,$subject_id);

		return $this->respondReportData(
			$report['additional_information'],
			$report['column_header'],
			$report['rows']
		);
	}

	/**
	 * Get student question report.
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getStudentQuestionReport(){

		$criteria = [];

		//isset student
		if(Input::get('student_id')){
			$criteria['student_id'] = Input::get('student_id');
		} else {
			return $this->respond(
				[
					'status' => $this->getStatus(),
					'errors' => str_replace(':attribute','Student',trans('errors.'. 1003))
				]
			);
		}

		//isset subject
		if(Input::get('subject_id')){
			$criteria['subject_id'] = Input::get('subject_id');
		}

		//isset level
		if(Input::get('grade_id')){
			$criteria['grade_id'] = Input::get('grade_id');
		}

		//isset module
		if(Input::get('module_id')){
			$criteria['module_id'] = Input::get('module_id');
		}

		$report = $this->student_report->getStudentQuestionReport($criteria);

		return $this->respondReport($report);
	}

}
