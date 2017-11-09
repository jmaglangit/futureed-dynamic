<?php namespace FutureEd\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

use FutureEd\Http\Controllers\Api\Traits\MessageBagTrait;
use FutureEd\Http\Controllers\Api\Traits\ErrorMessageTrait;
use FutureEd\Services\ErrorServices as Errors;

use Symfony\Component\HttpFoundation\Response;


abstract class ApiRequest extends FormRequest {

	use MessageBagTrait;
	use ErrorMessageTrait;

	private $status_code = Response::HTTP_OK;
	private $header = [];

	/**
	* returns the status code
	* @return mixed
	*/
	public function getStatusCode() {
		return $this->status_code;
	}

	/**
	* returns the headers
	* @return mixed
	*/
	public function getHeader() {
		return $this->header;
	}

	/**
	 * Get the proper failed validation response for the request. Override form request
	 *
	 * @param  array  $errors
	 * @return FutureEd Error Response
	 */
	public function response(array $errors) {
		
		$error_service = new Errors();
		
		$route_name = $this->route()->getName();
		
		foreach($errors as $field => $messages) {
			
			if(count($messages) > 0) {
				
				$this->addMessageBag(
					$this->setErrorCode($error_service->getErrorCodeByRouteName($route_name, $field))
                    ->setField($field)
                    ->setMessage($messages[0])
                    ->errorMessage()
                );
                
			}
			
		}
	
		return $this->respondWithError($this->getMessageBag());
	}
	
	
	/**
	 * Returns json format of the errors. COPY from API Controller
	 *
	 * @param  array data
	 * @return json
	 */
    public function respond($data){

        return Response()->json($data, $this->getStatusCode(), $this->getHeader());

    }
    
    /**
	 * Format the error response. COPY from API Controller
	 *
	 * @param  mixed  $message
	 * @return $this->respond
	 */
	public function respondWithError($message = 'Not Found!') {
	
		return $this->respond(
			[
				'status' => $this->getStatusCode(),
				'errors' => $message
			]
		);
	
	}
}