<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenController extends ApiController {



	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
    {
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];
        $payload = [
            'iss' => url(),
            'exp' => time(),
            'user' => 'futureEd',
            'admin' => true
        ];


        $encodedString = base64_encode(json_encode($header)) . "." . base64_encode(json_encode($payload));

        $signature = hash_hmac('sha1',$encodedString,'secret');


        return $encodedString . "." . $signature;

	}

    public function decode(){
        $input = Input::only('jwt_token');

        if(!$input['jwt_token']){

            return $this->setStatusCode(204)->respondWithError('No token detected.');
        }

        $decodeString = explode('.', $input['jwt_token']);

        $header = json_decode(base64_decode($decodeString[0]));
        $payload = json_decode(base64_decode($decodeString[1]));



    }



}
