<?php namespace FutureEd\Http\Controllers\Api\Reports;

use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;


class StudentReportExportController extends ReportController {

	/**
	 * @var StudentReportController
	 */
	protected $student_report;

	/**
	 * StudentReportExportController constructor.
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
	 * @return mixed
	 */
	public function studentStatusReport($student_id, $file_type){

		$report = $this->student_report->getStudentStatusReport($student_id);

		return Excel::create('StudentStatusReport')->export($file_type);

	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @param $file_type
	 * @return mixed
	 */
	public function studentProgressReport($student_id, $subject_id, $file_type){

		$report = $this->student_report->getStudentProgressReport($student_id,$subject_id);

		return Excel::create('filename')->export($file_type);
	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @param $file_type
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function studentSubjectGradeProgressReport($student_id, $subject_id, $file_type){

		$report = $this->student_report->getStudentSubjectGradeProgressReport($student_id,$subject_id);

		// Create export format.
		//File name format  --> first_name _ last_name _ tab_name _ date
		$student_info = $report['additional_information'];
		$file_name = $student_info['first_name'].'_'.$student_info['last_name'].'_Subject_Area_'. Carbon::now()->toDateString();
		$file_name = str_replace(' ','_',$file_name);


		//Execute output.
		switch($file_type){

			case 'pdf':
				$pdf = \PDF::loadView('export.student.subject-area-pdf', $report)->setPaper('a4')->setOrientation('landscape');
				return $pdf->download($file_name.'.'.$file_type);
				break;
			case 'xls' || 'xlsx':
				//Initiate format
				ob_end_clean();
				ob_start();
				Excel::create($file_name,function($excel) use ($report){

					$excel->sheet('NewSheet', function($sheet) use ($report){

						$sheet->mergeCells('A1:M1');
						$sheet->mergeCells('A3:A5');
						$sheet->setOrientation('landscape');
						$sheet->loadView('export.student.subject-area-excel',$report);
					});
				})->download($file_type);
				break;
			default:

				return $this->respondErrorMessage(2063);
				break;
		}

	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @param $file_type
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function studentCurrentLearning($student_id, $subject_id, $file_type){

		$report = $this->student_report->getStudentCurrentLearning($student_id,$subject_id);
		$student_info = $report['additional_information'];
		$file_name = $student_info['first_name'].'_'.$student_info['last_name'].'_Current_Learning_'. Carbon::now()->toDateString();
		$file_name = str_replace(' ','_',$file_name);

		//Export file
		switch ($file_type) {

			case 'pdf':
				$pdf = \PDF::loadView('export.student.current-learning-pdf', $report)->setPaper('a4')->setOrientation('portrait');
				return $pdf->download($file_name . '.' . $file_type);
				break;

			case 'xls' || 'xlsx':
				//Initiate format
				ob_end_clean();
				ob_start();
				Excel::create($file_name, function ($excel) use ($report) {

					$excel->sheet('NewSheet', function ($sheet) use ($report) {

						$sheet->mergeCells('A1:C1');
						$sheet->mergeCells('A3:A5');
						$sheet->setOrientation('portrait');
						$sheet->loadView('export.student.current-learning-excel', $report);
					});
				})->download($file_type);
				break;

			default:
				return $this->respondErrorMessage(2063);
				break;
		}
	}

}
