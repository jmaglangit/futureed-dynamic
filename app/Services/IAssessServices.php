<?php

namespace FutureEd\Services;

use FutureEd\Models\Traits\LoggerTrait;

class IAssessServices {

	use LoggerTrait;

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

	/**
	 *  holds student services
	 */
	protected $student_service;

	public function __construct(
		StudentServices $studentServices
	) {
		$curl = new \Curl\Curl();
		$this->curl = $curl;
		$this->student_service = $studentServices;
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

				$this->errorLog('IASSESS : '. $this->error_code . '/ '. $this->curl->error_message
						. '/ ' . $this->curl->http_error_message);
				
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
	    		
			    $this->curl->get(env('IASSESS_URL').'/api/v1/tests/'.($is_adult ? config('futureed.lsp_adult_id')
								: config('futureed.lsp_child_id') ).'/questions?user_id='.$this->user_id.'&token='.$this->token);
			    
			    if ($this->curl->error) {
				
					$this->error_code = $this->curl->error_code;

					$this->errorLog('IASSESS : '. $this->error_code . '/ '. $this->curl->error_message
							. '/ ' . $this->curl->http_error_message);
					
					return FALSE;
				
				} else {
					
					$this->data = json_decode($this->curl->response, true);
					
					return TRUE;
				}
	    	} else {

				$this->errorLog('IASSESS : Invalid user and token, ' . $this->user_id . ', ' . $this->token );
		    	return FALSE;
	    	}
    	} else {

			$this->errorLog('IASSESS : Invalid login');
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

					$this->errorLog('IASSESS : '. $this->error_code . '/ '. $this->curl->error_message
							. '/ ' . $this->curl->http_error_message);
					
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
				$this->errorLog('IASSESS : Invalid user and token, ' . $this->user_id . ', ' . $this->token );
		    	return FALSE;
	    	}
    	} else {
			$this->errorLog('IASSESS : Invalid login');
	    	return FALSE;
    	}
    }

	/**
	 * Call IAssess api for calculation.
	 * @param $student
	 * @param bool|false $is_adult
	 * @return bool
	 */
	public function calculateTestData($student,$is_adult = false){

			if($this->user_id && $this->token){

				$data = [
					'first_name' => $student->first_name,
					'last_name' => $student->last_name,
					'nric_fin_passport' => '-',
					'client_name' => env('APP_NAME','FutureEd'),
					'gender' => strtolower($student->gender),
					'user_id' => $this->user_id,
					'token' => $this->token,
				];

				$json = json_encode($data);

				$this->curl->setHeader('Content-Type','application/json');

				$this->curl->post(env('IASSESS_URL') . '/api/v1/clients/student/' . $student->id . '/test/'
						. ($is_adult ? config('futureed.lsp_adult_id')
						: config('futureed.lsp_child_id') ) . '/end-test', $json);

				if($this->curl->error){

					$this->error_code = $this->curl->error_code;

					$this->errorLog('IASSESS : '. $this->error_code . '/ '. $this->curl->error_message
						. '/ ' . $this->curl->http_error_message);

					return FALSE;
				} else {

					$this->data = json_decode($this->curl->response, true);

					return TRUE;
				}

			} else {
				$this->errorLog('IASSESS : Invalid user and token, ' . $this->user_id . ', ' . $this->token );
				return FALSE;
			}
	}

	/**
	 * IAssess Link to LSP report.
	 * @param $student_id
	 * @param bool|false $is_adult
	 * @return bool|string
	 */
	public function downloadReport($student_id,$is_adult = false){

		if($this->login()) {
			if($this->user_id && $this->token) {

				$link =  env('IASSESS_URL').'/api/v1/clients/student/' . $student_id  . '/test/'
				. ($is_adult ? config('futureed.lsp_adult_id') : config('futureed.lsp_child_id') )
				. '/download-report?user_id=' . $this->user_id . '&token=' . $this->token;

				$this->curl->get($link);

				if ($this->curl->error) {

					$this->error_code = $this->curl->error_code;

					$this->errorLog('IASSESS : '. $this->error_code . '/ '. $this->curl->error_message
						. '/ ' . $this->curl->http_error_message);

					return [
						'response' => false,
						'error' => json_decode($this->curl->response)
					];

				} else {

					return [
						'response' => true,
						'link' => $link
					];
				}

			} else {

				$this->errorLog('IASSESS : Invalid user and token, ' . $this->user_id . ', ' . $this->token );
				return FALSE;
			}
		} else {

			$this->errorLog('IASSESS : Invalid login');
			return FALSE;
		}
	}

	public function isAdult($student_id){

		return ($this->student_service->getAge($student_id) >= config('futureed.lsp_for_adult_age')) ? true : false;
	}
}