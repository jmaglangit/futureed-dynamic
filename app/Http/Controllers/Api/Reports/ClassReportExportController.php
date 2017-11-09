<?php namespace FutureEd\Http\Controllers\Api\Reports;

use Carbon\Carbon;
use FutureEd\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

class ClassReportExportController extends ReportController {

	/**
	 * @var ClassReportController
	 */
	protected $class_report;

	/**
	 * ClassReportExportController constructor.
	 * @param ClassReportController $classReportController
	 */
	public function __construct(
		ClassReportController $classReportController
	) {
		$this->class_report = $classReportController;
	}

	/**
	 * @param $class_id
	 * @param $file_type
	 * @return mixed
	 */
	public function classReport($class_id, $file_type){
		$report = $this->class_report->getClassReport($class_id);
		$teacher_info = $report['additional_information'];
		$file_name = $teacher_info['teacher_first_name'].'_'.$teacher_info['teacher_last_name'].'_Class_Report_'. Carbon::now()->toDateString();

		//Export file
		switch ($file_type) {
			case 'pdf':
				$pdf = \PDF::loadView('export.client.teacher.class-report-pdf', $report)->setPaper('a4')->setOrientation('portrait');
				return $pdf->download($file_name . '.' . $file_type);
				break;

			case 'xls' || 'xlsx':
				//Initiate format
				ob_end_clean();
				ob_start();
				Excel::create($file_name, function ($excel) use ($report) {
					$excel->sheet('NewSheet', function ($sheet) use ($report) {
						$sheet->setOrientation('portrait');
						$sheet->loadView('export.client.teacher.class-report-excel', $report);
					});
				})->download($file_type);
				break;

			default:
				return $this->respondErrorMessage(2063);
				break;
		}
	}

}
