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
        $token_data = [
            'url' => Request::capture()->fullUrl()
        ];

        return $this->token->getToken($token_data);
    }


    public function tokenDecode(){
        $input = Input::only('access_token');

        if(!$input['access_token']){

            return $this->setStatusCode(204)->respondWithError('No token detected.');

        }

        return $this->token->decodeToken($input['access_token']);


    }



}
