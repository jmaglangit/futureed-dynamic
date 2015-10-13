<?php namespace FutureEd\Http\Controllers\Api\Logs;

use FutureEd\Http\Requests;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;


class ErrorLogController extends LogController {

	/**
	 * Get list of error logs.
	 * @return \Illuminate\Http\Response
	 */
	public function getErrorLogs(){

		$storage = Storage::disk('logs')->files();

		$laravel_logs = [];
		foreach($storage as $files => $filename){

			//parse if laravel
			if(preg_match('/^laravel/',$filename)){

				$laravel_logs = array_merge($laravel_logs,[$filename]);

			}
		}

		$additional_information = [];
		$column_header = [
			'log_file' => 'Log Files'
		];
		$rows = $laravel_logs;

		return $this->respondLogData($additional_information, $column_header, $rows);

	}

	/**
	 * Download error log.
	 * @param $filename
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function downloadErrorLog($log_file){

		//check if in the list
		$storage = Storage::disk('logs')->files();

		$laravel_logs = [];
		foreach($storage as $files => $filename){

			//parse if laravel
			if(preg_match('/^laravel/',$filename)){

				$laravel_logs = array_merge($laravel_logs,[$filename]);

			}
		}

		//check if file in the list
		if(in_array($log_file,$laravel_logs)){

			return response()->download(storage_path() . '/logs/' . $log_file);
		}else {

			return $this->respondErrorMessage(2059);
		}

	}

}
