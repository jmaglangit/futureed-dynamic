<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Services\MailServices;
use FutureEd\Services\TokenServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use FutureEd\Services\CodeGeneratorServices;


class TokenController extends ApiController {



    public function __construct( TokenServices $token, CodeGeneratorServices $codeGen, MailServices $mail){
        $this->token = $token;
        $this->codeGen = $codeGen;
        $this->mail = $mail;
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


    public function getCode(){

        return $this->codeGen->getCodeExpiry();

    }

    public function sendMail(){

//        $url = action('Api\v1\ApiController@index', ['email' => 'jmaglangit@nerubia.com']);
        $url = secure_url('student/email/confirm', ['email' => 'jmaglangit@nerubia.com']);

        return $url;


    }

    public function eatme(){
        $input = Input::get('id');

        if($input['id'] == 9 ){
            return 'yes';
        }
        return $input;
    }



}
