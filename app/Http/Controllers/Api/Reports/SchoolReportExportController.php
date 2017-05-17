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

    /**
     * @param $school_code
     * @param $grade_level
     * @param $file_type
     * @return mixed
     */
    public function schoolTeacherSubjectProgress($school_code, $grade_level, $file_type){

        $report = $this->school_report->getSchoolTeacherSubjectProgress($school_code, $grade_level);

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

                        $last_letter = $this->getColumnLetter(count($report['column_header']));

//                        dd($this->columnWidth($this->teacherMaxWidth($report['column_header']), count($report['column_header'])));

                        $sheet->mergeCells('A1:' . $last_letter . '1');
                        $sheet->mergeCells('A2:' . $last_letter . '2');
                        $sheet->mergeCells('A3:' . $last_letter . '3');
                        $sheet->mergeCells('A4:' . $last_letter . '4');
                        $sheet->mergeCells('A5:' . $last_letter . '5');
                        $sheet->mergeCells('A7:' . $last_letter . '7');

//                        dd($this->nameMaxWidth($report['rows']));
                        $sheet->setWidth('A', $this->nameMaxWidth($report['rows']));
                        $sheet->setWidth($this->columnWidth($this->teacherMaxWidth($report['column_header']), count($report['column_header'])));


                        $sheet->setOrientation('landscape');
                        $sheet->loadView('export.client.principal.school-teacher-subject-progress-excel',$report);
                    });

                })->download($file_type);
                break;

            default:
                return $this->respondErrorMessage(2063);
                break;
        }
    }

    /**
     * @param $width
     * @param $count
     * @return array
     */
    private function columnWidth($width, $count) {

        $column_width = array();

        $letter_num = 66; // B in ASCII

        for($i = 0; $i < $count; $i++) {

            $column_width[chr($letter_num++)] = $width;

        }

        return $column_width;

    }

    /**
     * @param $column_header
     * @return int
     */
    private function teacherMaxWidth($column_header) {

        $max = 0;

        foreach ($column_header as $header) {

            $header_length = strlen($header);

            if ($max < $header_length)

                $max = $header_length;

        }

        return $max * 1.1;

    }

    private function nameMaxWidth($rows) {

        $max = 0;

        foreach (array_keys($rows) as $name) {

            $name_length = strlen('Teacher ' . $name);

            if ($max < $name_length)

                $max = $name_length;

        }

        return $max;

    }

    private function getColumnLetter($num_of_columns) {

        $numeric = ($num_of_columns) % 26;
        $letter = chr(65 + $numeric);
        $num_of_columns2 = intval(($num_of_columns - 1) / 26);

        if ($num_of_columns2 > 0) {

            return $this->getColumnLetter($num_of_columns2) . $letter;

        } else {

            return $letter;

        }

    }

}
