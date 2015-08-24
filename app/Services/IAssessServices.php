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
        
        if(env('IASSESS_URL') && env('IASSESS_URL') != '') {
	        $this->curl->post(env('IASSESS_URL').'/api/v1/user/login', array(
	        	'type' => 'client',
			    'login' => env('IASSESS_LOGIN', ''),
			    'password' => env('IASSESS_PASSWORD', ''),
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
        		
    }
    
    /**
     * Gets the LSP test data
     *
     * @param void
     * @return boolean
     */
    public function getTestData($is_adult = false) {
    	if($this->login()) {
	    	if($this->user_id && $this->token) {
	    		
			    $this->curl->get(env('IASSESS_URL').'/api/v1/tests/'.($is_adult ? config('futureed.lsp_adult_id') : config('futureed.lsp_child_id') ).'/questions?user_id='.$this->user_id.'&token='.$this->token);
			    
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
    
    /**
     * Saves the LSP test data
     *
     * @param void
     * @return boolean
     */
    public function saveTestData($data) {
    	if($this->login()) {
	    	if($this->user_id && $this->token) {
	    			    		
	    		$data['user_id'] = $this->user_id;
				$data['token'] = $this->token;
				$data['overwrite'] = true;

				$json = json_encode($data);				
								
				$this->curl->setHeader('Content-Type', 'application/json');
				
			    $this->curl->post(env('IASSESS_URL').'/api/v1/candidates/tests/answer-questions', $json);
			    
			    if($this->curl->error) {
				
					$this->error_code = $this->curl->error_code;
					
/*
					error_log($this->error_code);
					error_log($this->curl->error_message);
					error_log($this->curl->http_error_message);
*/
					
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