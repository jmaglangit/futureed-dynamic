<?php namespace FutureEd\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ReportServices {

	//generate hash filename
	public function createReportFileFolder($data){

		$file_folder = sha1($data . Carbon::now()->timestamp);

		Storage::makeDirectory(config('futureed.reports_folder').'/'.$file_folder);

		return [
			'path' => config('futureed.reports_folder').'/'.$file_folder,
			'folder_name' => $file_folder
		];;
	}

	public function saveReportFileFolder($file_location, $contents){

		return Storage::put($file_location,$contents);
	}

	public function getReportFileURL($file_folder){

		$route_name = route('api.report.folder.file',[
			'folder_name' => $file_folder
		]);

		return $route_name;
	}


}