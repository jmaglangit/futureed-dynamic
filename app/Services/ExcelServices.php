<?php namespace FutureEd\Services;

use Maatwebsite\Excel\Facades\Excel;

class ExcelServices extends Excel{


	public function importCsv($csv_file,$headers = []){

		return Excel::load($csv_file,function ($reader){})->get($headers);

	}

}