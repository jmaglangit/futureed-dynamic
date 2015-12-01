<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Services\ExcelServices;
use FutureEd\Http\Requests\Api\StudentImportRequest;

class StudentImportController extends ApiController {

	protected $excel_services;

	public function __construct(
		ExcelServices $excelServices
	){
		$this->excel_services = $excelServices;
	}

	public function studentImport(StudentImportRequest $request){


		//generate services to import
//		$this->excel_services->importCsv(Input::file('file'));

	}

}
