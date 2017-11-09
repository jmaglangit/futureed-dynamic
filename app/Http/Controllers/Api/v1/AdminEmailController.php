<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\AdminEmailRequest;

class AdminEmailController extends ApiController {

	public function checkEmail($admin_id, AdminEmailRequest $request) {
		$input = $request->only('email');
		
		$email = $input['email'];
		
		return $this->respondWithData(true);		
	}
	
}