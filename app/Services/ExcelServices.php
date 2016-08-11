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

	public function exportCsv($rows,$filename){

		return Excel::create($filename, function($excel) use ($rows,$filename){

			$excel->sheet(substr($filename,0,29), function($sheet) use ($rows) {

				$sheet->fromArray($rows);
			});

		});
	}

}