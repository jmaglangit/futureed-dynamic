<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/27/15
 * Time: 5:15 PM
 */

namespace FutureEd\Services;


use Carbon\Carbon;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
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

    protected $token_config;

    protected $user;

    protected $payload;



    public function __construct(UserRepositoryInterface $userRepositoryInterface){
        $this->token_config = config('token');
        $this->user = $userRepositoryInterface;
    }

    /**
     * set payload
     *
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }


    /**
     * setting up header
     * @return string
     */
    public function setHeader(){
        $header = [
            //set algorithm of the token
            'alg' => $this->token_config['alg'],
            //set type of token | default into JWT
            'typ' => $this->token_config['typ']
        ];

        return base64_encode(json_encode($header));
    }

    /**
     * setting up payload
     *
     * @param $token
     * @return string
     */
    public function setPayload($token){

        //check if id exist then get user id details
        //check if client the




//        dd(Carbon::now()->addSeconds($this->token['exp'])->toDateTimeString());
        $payload = [

            //full url of the issuer or just the main url
            'iss' => (isset($token['url'])) ? $token['url'] : Request::capture()->fullUrl(),

            //time expiry of the token in unix set or auto set
            'exp' => (isset($token['exp'])) ?
                        $token['exp']
                        : Carbon::now()->addSeconds($this->token_config['exp'])->timestamp,

            'iat' => (isset($token['iat'])) ?
                        $token['iat']
                        : Carbon::now()->timestamp,
            //app name
            'app' => $this->token_config['app'],

            //set user id of the user
            'id' => (isset($token['id'])) ?
                        $token['id']
                        : 0,

            //set user type of the user
            'type' => (isset($token['type'])) ?
                        $token['type']
                        : 'Guest',

            //set user role
            'role' => (isset($token['role'])) ?
                        $token['role']
                        : false

        ];

        $this->payload = $payload;

        return base64_encode(json_encode($payload));
    }

    public function setSignature($header,$payload){

        $encodedString = $header . "." . $payload;
        return Hash_hmac('sha1',$encodedString,'FutureLessonsOfFutureEd');

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
        $payload_decoded = json_decode(base64_decode($payload),true);

        //validate url
        //if(!$this->validateTokenUrl($payload_decoded['iss'])){
        //    return false;
        //}

        //validate app
        //if(!$this->validateTokenApp($payload_decoded['app'])){
        //    return false;
        //}

        //validate user
        if(!$this->validateTokenUser($payload_decoded['id'],$payload_decoded['type'])){
            return false;
        }

        $this->setPayload($payload_decoded);

        return $payload_decoded;
    }


    /**
     * @param $token
     * @return bool
     */
    public function validateToken($token){

        $token_decoded = explode(".",$token);



        if($token_decoded[0] && $token_decoded[1] && $token_decoded[2]){

            //check details for comparison
            $header = $this->decodeHeader($token_decoded[0]);

            //check details for comparison
            $payload = $this->decodePayload($token_decoded[1]);

        } else {
            return false;
        }



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


    /**
     * validate signature between with header and payload.
     *
     * @param $received_sign
     * @param $calculated_sign
     * @return bool
     */
    public function validateSignature($received_sign,$calculated_sign){

        return str_is($received_sign,$calculated_sign);
    }



    /**
     * validate user id and type.
     *
     * @var id int
     * @var type string
     *
     * @return bool
     */
    public function validateTokenUser($id,$type){

        $user_data = $this->user->getUser($id,$type);

        if($user_data){

            return true;
        }

        return false;
    }

    /**
     * validate url with the app url if valid.
     *
     * @param $url
     *
     * @return bool
     */
    public function validateTokenUrl($url){

        $url_curr = url();

        if(stristr($url,$url_curr) == true){

            return true;
        }

        return false;
    }

    /**
     * validate app if matched.
     *
     * @param $app
     * @return bool
     */
    public function validateTokenApp($app){

        if($app == $this->token_config['app']){

            return true;
        }

        return false;
    }



}