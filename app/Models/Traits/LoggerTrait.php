<?php namespace FutureEd\Models\Traits;


use Illuminate\Support\Facades\Log;

trait LoggerTrait {

	//TODO: Place all logs to the database.


	//Log Emergency
	public function emergencyLog($error) {

		Log::emergency($error);

	}

	//Log Alert
	public function alertLog($error) {

		Log::alert($error);

	}

	//Log Critical
	public function criticalLog($error){

		Log::critical($error);

	}

	//Log Error
	public function errorLog($error){

		Log::error('FUTUREED_ERROR: ' . $error);
	}

	//Log Warning
	public function warningLog($error){

		Log::warning($error);

	}

	//Log Notice
	public function noticeLog($error){

		Log::notice($error);

	}

	//Log Info
	public function infoLog($error){

		Log::info($error);

	}

	//Log Debug
	public function debugLog($error){

		Log::debug($error);

	}


}