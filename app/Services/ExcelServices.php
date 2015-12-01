<?php namespace FutureEd\Services;

use Maatwebsite\Excel\Facades\Excel;

class ExcelServices {

	protected $excel;

	public function __construct(
		Excel $excel
	) {
		$this->excel=$excel;
	}

	public function importCsv($csv_file){

		Excel::load($csv_file,function ($reader){

			dd($reader);
		});

	}

}