<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/27/15
 * Time: 5:15 PM
 */

namespace FutureEd\Services;


use Carbon\Carbon;
use Illuminate\Http\Request;

class TokenServices {

   //set header
    //set claims
    //get signature
    //output token
    //TODO: determine the user and its access. time expiry, type of user.

    /**
     * @desc set user
    iss: The issuer of the token
    sub: The subject of the token
    aud: The audience of the token
    exp: Token expiration time defined in Unix time
    nbf: “Not before” time that identifies the time before which the JWT must not be accepted for processing
    iat: “Issued at” time, in Unix time, at which the token was issued
    jti: JWT ID claim provides a unique identifier for the JWT

     */

    public $token;

    public function __construct(){
        $this->token = config('token');
    }

    public function setHeader(){
        $header = [
            //set algorithm of the token
            'alg' => $this->token['alg'],
            //set type of token | default into JWT
            'typ' => $this->token['typ']
        ];

        return base64_encode(json_encode($header));
    }

    public function setPayload($token){

        //get full url of the requester
        //get time expiration of the token
        //get default company
        //get app name
        //get if admin


//        dd(Carbon::now()->addSeconds($this->token['exp'])->toDateTimeString());
        $payload = [
            //full url of the issuer or just the main url
            'iss' => (isset($token['url'])) ? $token['url'] : Request::capture()->fullUrl(),

            //time expiry of the token in unix set or auto set
            'exp' => (isset($token['exp'])) ?
                        $token['exp']
                        : Carbon::now()->addSeconds($this->token['exp'])->timestamp,

            'iat' => (isset($token['iat'])) ?
                        $token['iat']
                        : Carbon::now()->timestamp,
            //app name
            'app' => $this->token['app'],

            //set user id of the token user
            'user' => (isset($token['user']))
        ];

        return base64_encode(json_encode($payload));
    }

    public function setSignature($header,$payload){

        $encodedString = $header . "." . $payload;
        return Hash_hmac('sha1',$encodedString,'secret');

    }

    /*
     * @desc generate token
     */
    public function getToken($payload_data = []){

        $header = $this->setHeader();
        $payload = $this->setPayload($payload_data);
        $signature = $this->setSignature($header,$payload);

        return [
            'authorization' => $header . "." . $payload . "." . $signature
        ];
    }



    public function decodeHeader($header){

        //set filter for the data
        return json_decode(base64_decode($header),true);

    }

    public function decodePayload($payload){

        //set filters for data
        return json_decode(base64_decode($payload),true);
    }


    /*
     * @desc decodes token
     */
    public function validateToken($token){

        $token_decoded = explode(".",$token);


        //check details for comparison
        $header = $this->decodeHeader($token_decoded[0]);

        //check details for comparison
        $payload = $this->decodePayload($token_decoded[1]);

        $token_exp = new Carbon();
        $token_exp->timestamp = $payload['exp'];

        $signature = $this->setSignature($token_decoded[0],$token_decoded[1]);

        if(Carbon::now()->timestamp >= $token_exp->timestamp){

            return false;
        }

        if (!$this->validateSignature($token_decoded[2],$signature)){

            return false;
        }

        return true;


    }



    public function validateSignature($received_sign,$calculated_sign){

        return str_is($received_sign,$calculated_sign);

    }



}