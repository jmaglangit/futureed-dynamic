<?php

namespace FutureEd\Services;

class IAssessServices {

	/**
     *   holds the user_id returned by the login from iAssess
     */
	var $user_id;
	
	/**
     *   holds the token returned by the login from iAssess
     */
	var $token;
	
	/**
     *   holds the cURL error_code
     */
	var $error_code;
	
	/**
     *   holds the cURL object
     */
	var $curl;
	
	/**
     *   holds the data if successful cURL has been done
     */
	var $data;
	
	public function __construct() {
		$curl = new \Curl\Curl();
		$this->curl = $curl;
	}
	
    /**
     * Logs into iAssess as client
     *
     * @param void
     * @return boolean
     */
    private function login() {
        
        $this->curl->post('http://beta.measure.iassessonline.com/api/v1/user/login', array(
        	'type' => 'client',
		    'login' => 'futureed',
		    'password' => 'FutureEd123',
		));
		
		if ($this->curl->error) {
		
			$this->error_code = $this->curl->error_code;
			
			return FALSE;
		
		} else {
			
			$response = json_decode($this->curl->response);
			
			$this->user_id = $response->user_id;
			$this->token = $response->token;
			
			return TRUE;
		}		
    }
    
    /**
     * Gets the LSP test data
     *
     * @param void
     * @return boolean
     */
    public function getTestData() {
    	if($this->login()) {
	    	if($this->user_id && $this->token) {
			    $this->curl->get('http://beta.measure.iassessonline.com/api/v1/candidates/tests/774/sections?user_id='.$this->user_id.'&token='.$this->token);
			    
			    if ($this->curl->error) {
				
					$this->error_code = $this->curl->error_code;
					
					return FALSE;
				
				} else {
					
					$this->data = json_decode($this->curl->response, true);
					
					return TRUE;
				}
	    	} else {
		    	return FALSE;
	    	}
    	} else {
	    	return FALSE;
    	}
    }

}