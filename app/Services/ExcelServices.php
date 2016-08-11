<?php namespace FutureEd\Services;

use Maatwebsite\Excel\Facades\Excel;

class ExcelServices extends Excel{

	/**
	 * Parse uploaded csv file and returns array.
	 * @param $csv_file
	 * @param array $headers
	 * @return mixed
	 */
	public function importCsv($csv_file,$headers = []){

		return Excel::load($csv_file,function ($reader){})->get($headers);

	}

	public function exportCsv($rows,$headers){

		return Excel::create('Filename', function($excel) use ($rows,$headers){

			$excel->sheet('Sheetname', function($sheet) use ($rows,$headers) {

				$sheet->row(1,$headers);
				$sheet->appendRow(2,$rows);
			});

		});
	}

}