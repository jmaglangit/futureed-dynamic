<?php namespace FutureEd\Http\Controllers\Api\Reports;

use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use FutureEd\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;


class SchoolReportExportController extends ReportController {

	protected $school_report;

	protected $pdf;

	protected $excel;

	public function __construct(
		SchoolReportController $schoolReportController,
		PDF $PDF,
		Excel $excel
	) {
		$this->school_report = $schoolReportController;
		$this->pdf = $PDF;
		$this->excel = $excel;
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

		//File name format  --> first_name _ last_name _ tab_name _ date
		$school_info = $report['additional_information'];
		$file_name = $school_info['principal_name'].'_'.$school_info['school_name'].'_School_Progress_'. Carbon::now()->toDateString();
		$file_name = str_replace(' ','_',$file_name);

		//Export file
		switch ($file_type) {

			case 'pdf':

				$export_pdf = $this->pdf->loadView('export.client.principal.school-progress-pdf', $report)
						->setPaper('a4')
						->setOrientation('portrait');
				return $export_pdf->download($file_name . '.' . $file_type);
				break;

			case 'xls' || 'xlsx':
				//Initiate format
				ob_end_clean();
				ob_start();
				Excel::create($file_name,function($excel) use ($report){

					$excel->sheet('NewSheet', function($sheet) use ($report){

						$sheet->mergeCells('A1:E1');
						$sheet->mergeCells('A2:E2');
						$sheet->mergeCells('A3:E3');
						$sheet->mergeCells('A4:E4');
						$sheet->mergeCells('A5:E5');
						$sheet->mergeCells('A7:E7');

						$sheet->setOrientation('landscape');
						$sheet->loadView('export.client.principal.school-progress-excel',$report);
					});
				})->download($file_type);
				break;

			default:
				return $this->respondErrorMessage(2063);
				break;
		}

	}

	/**
	 * @param $school_code
	 * @param $file_type
	 * @return mixed
	 */
	public function schoolTeacherProgress($school_code,$file_type){

		$report = $this->school_report->getSchoolTeacherProgress($school_code);

		//File name format  --> first_name _ last_name _ tab_name _ date
		$school_info = $report['additional_information'];
		$file_name = $school_info['principal_name'].'_'.$school_info['school_name'].'_School_Progress_'. Carbon::now()->toDateString();
		$file_name = str_replace(' ','_',$file_name);

		//Export file
		switch ($file_type) {

			case 'pdf':

				$export_pdf = $this->pdf->loadView('export.client.principal.school-teacher-progress-pdf', $report)
						->setPaper('a4')
						->setOrientation('portrait');
				return $export_pdf->download($file_name . '.' . $file_type);
				break;

			case 'xls' || 'xlsx':
				//Initiate format
				ob_end_clean();
				ob_start();
				Excel::create($file_name,function($excel) use ($report){

					$excel->sheet('NewSheet', function($sheet) use ($report){

						$sheet->mergeCells('A1:E1');
						$sheet->mergeCells('A2:E2');
						$sheet->mergeCells('A3:E3');
						$sheet->mergeCells('A4:E4');
						$sheet->mergeCells('A5:E5');
						$sheet->mergeCells('A7:E7');

						$sheet->setOrientation('landscape');
						$sheet->loadView('export.client.principal.school-teacher-progress-excel',$report);
					});
				})->download($file_type);
				break;

			default:
				return $this->respondErrorMessage(2063);
				break;
		}
	}

}
