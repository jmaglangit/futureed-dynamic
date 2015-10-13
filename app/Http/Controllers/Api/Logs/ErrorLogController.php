<?php namespace FutureEd\Http\Controllers\Api\Logs;

use FutureEd\Http\Requests;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;


class ErrorLogController extends LogController {

	/**
	 * Get error log files.
	 * @param Filesystem $filesystem
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
	 * Download laravel log file.
	 * @param $filename
	 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
	 */
	public function downloadErrorLog($filename){

		return response()->download(storage_path() . '/logs/' . $filename);

	}

}
