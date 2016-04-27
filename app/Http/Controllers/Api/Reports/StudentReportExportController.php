<?php namespace FutureEd\Http\Controllers\Api\Reports;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use FutureEd\Http\Requests;
use FutureEd\Services\ImageServices;
use FutureEd\Services\ReportServices;
use Maatwebsite\Excel\Facades\Excel;
use PhpSpec\Exception\Exception;
class StudentReportExportController extends ReportController {

	/**
	 * @var StudentReportController
	 */
	protected $student_report;
	protected $image_service;
	protected $pdf;
	protected $excel;
	protected $report_services;

	/**
	 * StudentReportExportController constructor.
	 * @param StudentReportController $studentReportController
	 * @param ImageServices $imageServices
	 * @param PDF $PDF
	 * @param Excel $excel
	 * @param ReportServices $reportServices
	 */
	public function __construct(
		StudentReportController $studentReportController,
		ImageServices $imageServices,
		PDF $PDF,
		Excel $excel,
		ReportServices $reportServices
	) {
		$this->student_report = $studentReportController;
		$this->image_service = $imageServices;
		$this->pdf = $PDF;
		$this->excel = $excel;
		$this->report_services = $reportServices;
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

			case config('futureed.pdf'):
				return $this->studentSubjectGradeProgressPdf($report)->download($file_name.'.'.$file_type);
				break;
			case config('futureed.xls'):
				return $this->studentSubjectGradeProgressExcel($report,$file_name)->download($file_type);
				break;
			case config('futureed.mobile-pdf'):

				//generate pdf
				$pdf_contents = $this->studentSubjectGradeProgressPdf($report)
						->download($file_name.'.'.$file_type);

				//create file folder
				$report_dir = $this->report_services->createReportFileFolder($file_name);

				//concat location and file.
				$report_file = $report_dir['path'].'/'.$file_name.'.pdf';


				//save file with contents
				$save_response = $this->report_services->saveReportFileFolder($report_file,$pdf_contents);

				if($save_response){
					//return generated report url
					return $this->respondReportDownloadLink($this->report_services->getReportFileURL($report_dir['folder_name']));

				}else {
					return $this->respondErrorMessage(2048);
				}

				break;
			case config('futureed.mobile-xls'):

				$report_dir = $this->report_services->createReportFileFolder($file_name);

				try{
					//generate excel
					ob_end_clean();
					ob_start();
					$this->studentSubjectGradeProgressExcel($report,$file_name,$report_dir);

					//return generate report url
					return $this->respondReportDownloadLink($this->report_services->getReportFileURL($report_dir['folder_name']));
				}catch (Exception $e){

					return $this->respondErrorMessage(2048);
				}

				break;
			default:

				return $this->respondErrorMessage(2063);
				break;
		}
	}

	/**
	 * Student Subject Grade Progress Report to PDF
	 * @param $data
	 * @return static
	 */
	public function studentSubjectGradeProgressPdf($data){

		//add pdf format
		$format = array_merge([
			'column_header_count' => count($data['column_header']),
			'column_header_neg' => count($data['column_header']) - 1,
			'column_header_floor' => floor(count($data['column_header'])/6),
			'column_header_ceil' => ceil(count($data['column_header'])/6),
		],config('futureed.report_export_style_subject'));

		$data['format'] = $format;

		$data = $this->exportCellGenerator($data);

		return $this->pdf->loadView('export.student.subject-area-pdf', $data)->setPaper('a4')->setOrientation('landscape');
	}

	//report to excel
	/**
	 * Student Subject Grade Progress Report to Excel
	 * @param $data
	 * @param $name
	 * @param null $report_dir
	 * @return mixed
	 */
	public function studentSubjectGradeProgressExcel($data, $name, $report_dir = null){

		//Added excel format
		$format = array_merge([
			'column_header_count' => count($data['column_header']),
			'column_header_floor' => floor(count($data['column_header'])/6),
			'column_header_ceil' => ceil(count($data['column_header'])/6),
		],config('futureed.report_export_style_subject'));

		$data['format'] = $format;

		$data = $this->exportCellGenerator($data);

		ob_end_clean();
		ob_start();
		if(empty($report_dir)){
			return Excel::create($name,function($excel) use ($data){

				$excel->sheet('NewSheet', function($sheet) use ($data){

					$sheet->mergeCells('A1:M1');
					$sheet->mergeCells('A3:A5');
					$sheet->setOrientation('landscape');
					$sheet->loadView('export.student.subject-area-excel',$data);
				});
			});
		}else {
			return Excel::create($name,function($excel) use ($data){

				$excel->sheet('NewSheet', function($sheet) use ($data){

					$sheet->mergeCells('A1:M1');
					$sheet->mergeCells('A3:A5');
					$sheet->setOrientation('landscape');
					$sheet->loadView('export.student.subject-area-excel',$data);
				});
			})->store('xls',storage_path('app/'.$report_dir['path']));

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
		$report = $this->image_service->getIconImagePath($report);
		$student_info = $report['additional_information'];
		$file_name = $student_info['first_name'].'_'.$student_info['last_name'].'_Current_Learning_'. Carbon::now()->toDateString();
		$file_name = str_replace(' ','_',$file_name);

		//Export file
		switch ($file_type) {

			case config('futureed.pdf'):
				return $this->studentCurrentLearningPdf($report)->download($file_name . '.' . $file_type);
				break;

			case config('futureed.xls'):
				return $this->studentCurrentLearningExcel($report,$file_name)->download($file_type);
				break;

			case config('futureed.mobile-pdf'):

				//generate pdf
				$pdf_contents = $this->studentCurrentLearningPdf($report)
						->download($file_name.'.'.$file_type);

				//create file folder
				$report_dir = $this->report_services->createReportFileFolder($file_name);

				//concat location and file.
				$report_file = $report_dir['path'].'/'.$file_name.'.pdf';


				//save file with contents
				$save_response = $this->report_services->saveReportFileFolder($report_file,$pdf_contents);

				if($save_response){
					//return generated report url
					return $this->respondReportDownloadLink($this->report_services->getReportFileURL($report_dir['folder_name']));

				}else {
					return $this->respondErrorMessage(2048);
				}

				break;

				break;
			case config('futureed.mobile-xls'):

				$report_dir = $this->report_services->createReportFileFolder($file_name);

				try{
					//generate excel
					ob_end_clean();
					ob_start();
					$this->studentCurrentLearningExcel($report,$file_name,$report_dir);

					//return generate report url
					return $this->respondReportDownloadLink($this->report_services->getReportFileURL($report_dir['folder_name']));
				}catch (Exception $e){

					return $this->respondErrorMessage(2048);
				}

				break;

			default:
				return $this->respondErrorMessage(2063);
				break;
		}
	}

	/**
	 * Student Current Learning Report to PDF.
	 * @param $data
	 * @return static
	 */
	public function studentCurrentLearningPdf($data){
		return $this->pdf->loadView('export.student.current-learning-pdf', $data)->setPaper('a4')->setOrientation('portrait');
	}

	/**
	 * Student Current Learning Report to Excel.
	 * @param $data
	 * @param $name
	 * @param $report_dir
	 * @return mixed
	 */
	public function studentCurrentLearningExcel($data, $name, $report_dir){
		ob_end_clean();
		ob_start();
		if(empty($report_dir)){
			return Excel::create($name, function ($excel) use ($data) {

				$excel->sheet('NewSheet', function ($sheet) use ($data) {

					$sheet->mergeCells('A1:C1');
					$sheet->mergeCells('A3:A5');
					$sheet->setOrientation('portrait');
					$sheet->loadView('export.student.current-learning-excel', $data);
				});
			});
		}else {
			return Excel::create($name, function ($excel) use ($data) {

				$excel->sheet('NewSheet', function ($sheet) use ($data) {

					$sheet->mergeCells('A1:C1');
					$sheet->mergeCells('A3:A5');
					$sheet->setOrientation('portrait');
					$sheet->loadView('export.student.current-learning-excel', $data);
				});
			})->store('xls',storage_path('app/'.$report_dir['path']));
		}
	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @param $file_type
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getSubjectAreaHeatMap($student_id, $subject_id, $file_type){

		$report = $this->student_report->getSubjectAreaHeatMap($student_id,$subject_id);

		// Create export format.
		//File name format  --> first_name _ last_name _ tab_name _ date
		$student_info = $report['additional_information'];
		$file_name = $student_info['first_name'].'_'.$student_info['last_name'].'_Subject_Area_Heatmap_'. Carbon::now()->toDateString();
		$file_name = str_replace(' ','_',$file_name);


		//Execute output.
		switch($file_type){

			case config('futureed.pdf'):
				return $this->getSubjectAreaHeatMapPdf($report)->download($file_name.'.'.$file_type);
				break;
			case config('futureed.xls'):
				return $this->getSubjectAreaHeatMapExcel($report,$file_name)->download($file_type);
				break;
			case config('futureed.mobile-pdf'):

				//generate pdf
				$pdf_contents = $this->getSubjectAreaHeatMapPdf($report)
					->download($file_name.'.'.$file_type);

				//create file folder
				$report_dir = $this->report_services->createReportFileFolder($file_name);

				//concat location and file.
				$report_file = $report_dir['path'].'/'.$file_name.'.pdf';


				//save file with contents
				$save_response = $this->report_services->saveReportFileFolder($report_file,$pdf_contents);

				if($save_response){
					//return generated report url
					return $this->respondReportDownloadLink($this->report_services->getReportFileURL($report_dir['folder_name']));

				}else {
					return $this->respondErrorMessage(2048);
				}

				break;
			case config('futureed.mobile-xls'):

				$report_dir = $this->report_services->createReportFileFolder($file_name);

				try{
					//generate excel
					ob_end_clean();
					ob_start();
					$this->getSubjectAreaHeatMapExcel($report,$file_name,$report_dir);

					//return generate report url
					return $this->respondReportDownloadLink($this->report_services->getReportFileURL($report_dir['folder_name']));
				}catch (Exception $e){

					return $this->respondErrorMessage(2048);
				}

				break;
			default:

				return $this->respondErrorMessage(2063);
				break;
		}
	}

	/**
	 * Student Subject Grade Progress Report to PDF
	 * @param $data
	 * @return static
	 */
	public function getSubjectAreaHeatMapPdf($data){

		//add pdf format
		$format = array_merge([
			'column_header_count' => count($data['column_header']),
			'column_header_neg' => count($data['column_header']) - 1,
			'column_header_floor' => floor(count($data['column_header'])/6),
			'column_header_ceil' => ceil(count($data['column_header'])/6),
		],config('futureed.report_export_style'));

		$data['format'] = $format;

		$data = $this->exportCellGenerator($data);

		return $this->pdf->loadView('export.student.subject-area-heat-map-pdf', $data)->setPaper('a4')->setOrientation('landscape');
	}

	/**
	 * Student Subject Grade Progress Report to Excel
	 * @param $data
	 * @param $name
	 * @param null $report_dir
	 * @return mixed
	 */
	public function getSubjectAreaHeatMapExcel($data, $name, $report_dir = null){

		//Added excel format
		$format = array_merge([
			'column_header_count' => count($data['column_header']),
			'column_header_floor' => floor(count($data['column_header'])/6),
			'column_header_ceil' => ceil(count($data['column_header'])/6),
		],config('futureed.report_export_style'));

		$data['format'] = $format;


		//populate rows.
		$data = $this->exportCellGenerator($data);

		ob_end_clean();
		ob_start();
		if(empty($report_dir)){
			return Excel::create($name,function($excel) use ($data){

				$excel->sheet('NewSheet', function($sheet) use ($data){

					$sheet->mergeCells('A1:M1');
					$sheet->mergeCells('A3:A5');
					$sheet->setOrientation('landscape');
					$sheet->loadView('export.student.subject-area-heat-map-excel',$data);
				});
			});
		}else {
			return Excel::create($name,function($excel) use ($data){

				$excel->sheet('NewSheet', function($sheet) use ($data){

					$sheet->mergeCells('A1:M1');
					$sheet->mergeCells('A3:A5');
					$sheet->setOrientation('landscape');
					$sheet->loadView('export.student.subject-area-heat-map-excel',$data);
				});
			})->store('xls',storage_path('app/'.$report_dir['path']));

		}

	}

	/**
	 * Generate rows for export tables.
	 * @param $data
	 * @return mixed
	 */
	public function exportCellGenerator($data){

		foreach($data['rows'] as $row_data){

			//allocate rows.
			$row_progress = array_fill(0,count($data['column_header'])-1,[]);

			foreach($row_data->curriculum_data as $curr_data){
				$row_progress[$curr_data->grade_id -1] = $curr_data->toArray();
			}
			$row_data->curriculum_data = $row_progress;
		}

		return $data;
	}
}