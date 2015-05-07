<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Services\MailServices;
use FutureEd\Services\TokenServices;
use Illuminate\Support\Facades\Input;
use FutureEd\Services\CodeGeneratorServices;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;


class TokenController extends ApiController {



    public function __construct( TokenServices $token, CodeGeneratorServices $codeGen, MailServices $mail, MessageBag $messageBag){
        $this->token = $token;
        $this->codeGen = $codeGen;
        $this->mail = $mail;
        $this->messageBag = $messageBag;
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

    public function input(){
        $input = Input::only('name');
        $header = Request::header('access_token');

        $this->messageBag->add('errors',
            [
                'error_code' => 12344,
                'field' => 'field',
                'message' => 'is required'
            ]
        );

        $this->messageBag->add('errors',
            [
                'error_code' => 123232344,
                'field' => 'fields',
                'message' => 'are required'
            ]
        );


        $errors = $this->messageBag->getMessageBag()->toJson();
        return $errors;
    }



}
