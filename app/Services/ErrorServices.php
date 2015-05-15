<?php
namespace FutureEd\Services;

class ErrorServices {

	const DEFAULT_ERROR_CODE = 1001;

	/**
	* returns the error code specified by route and field
	* @return string
	*/
	public function getErrorCodeByRouteName($route_name, $field) {
		  
		  $error_code = self::DEFAULT_ERROR_CODE;
		  
		  switch($route_name) {
		  
			  default:
			  	$error_code = self::DEFAULT_ERROR_CODE;
			  	break;
		  }
		  
		  return $error_code;
		  
	}
	
	/**
	* returns the error message specified by route and field
	* @return string
	*/
	public function getErrorMessageByRouteName($route_name, $field) {
		  		  
		  return $this->getErrorMessageByCode($this->getErrorCodeByRouteName($route_name, $field));
		  
	}
	
	/**
	* returns the error message specified by code
	* @return string
	*/
	private function getErrorMessageByCode($error_code) {
	
		$error_messages = config('futureed-error.error_messages');
		
		if(isset($error_messages[$error_code])) {
			return 'Field error.';
		} else {
			return $error_messages[$error_code];
		}
		
	}

}