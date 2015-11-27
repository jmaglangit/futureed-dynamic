<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;
use Illuminate\Support\Facades\Storage;

class ReportFileController extends ReportController {

	/**
	 * Get report file on storage.
	 * @param $folder_name
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function getReportFile($folder_name){

		//check folder if exist.
		if(Storage::exists(config('futureed.reports_folder').'/'.$folder_name)){

			//getting a file on the folder.
			$contents = Storage::files(config('futureed.reports_folder').'/'.$folder_name);

			return response()->download(storage_path().'/app/'.$contents[0]);
		}else {

			return $this->respondErrorMessage(2064);
		}
	}

}
