<?php namespace FutureEd\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ReportServices {

	/**
	 * Generate Hash file foldername
	 * @param $data
	 * @return array
	 */
	public function createReportFileFolder($data){

		$file_folder = sha1($data . Carbon::now()->timestamp);

		Storage::makeDirectory(config('futureed.reports_folder').'/'.$file_folder);

		return [
			'path' => config('futureed.reports_folder').'/'.$file_folder,
			'folder_name' => $file_folder
		];;
	}

	/**
	 * Save report file folder.
	 * @param $file_location
	 * @param $contents
	 * @return mixed
	 */
	public function saveReportFileFolder($file_location, $contents){

		return Storage::put($file_location,$contents);
	}

	/**
	 * Generate Report file folder.
	 * @param $file_folder
	 * @return string
	 */
	public function getReportFileURL($file_folder){

		$route_name = route('api.report.folder.file',[
			'folder_name' => $file_folder
		]);

		return $route_name;
	}


}