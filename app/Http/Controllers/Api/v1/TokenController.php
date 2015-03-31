<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Services\TokenServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class TokenController extends ApiController {



    public function __construct( TokenServices $token){
        $this->token = $token;
    }
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

    public function test(){

        $token_data = [
            'url' => Request::capture()->fullUrl()
        ];


        return $this->token->getToken($token_data);
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


    public function tokenDecode(){
        $input = Input::only('access_token');

        if(!$input['access_token']){

            return $this->setStatusCode(204)->respondWithError('No token detected.');

        }

        return $this->token->decodeToken($input['access_token']);


    }



}
