<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/27/15
 * Time: 5:15 PM
 */

namespace FutureEd\Services;


class JWTServices {

    /**
     * get input data in the for JWT requirements
     * determine the information need for the token being passed to the interface.
     * encode the tokens to output for the passing variables.
     * decode the token and insure requirements to process
     *
     */


    //iss: The issuer of the token
    private $iss;

    //sub: The subject of the token
    private $sub;

    //aud: The audience of the token
    private $aud;

    //exp: Token expiration time defined in Unix time
    private $exp;

    //nbf: “Not before” time that identifies the time before which the JWT must not be accepted for processing
    private $nbf;

    //iat: “Issued at” time, in Unix time, at which the token was issued
    private $iat;

    //jti: JWT ID claim provides a unique identifier for the JWT
    private $jti;

    /**
     * @return mixed
     */
    public function getIss()
    {
        return $this->iss;
    }

    /**
     * @param mixed $iss
     */
    public function setIss($iss)
    {
        $this->iss = $iss;
    }

    /**
     * @return mixed
     */
    public function getSub()
    {
        return $this->sub;
    }

    /**
     * @param mixed $sub
     */
    public function setSub($sub)
    {
        $this->sub = $sub;
    }

    /**
     * @return mixed
     */
    public function getAud()
    {
        return $this->aud;
    }

    /**
     * @param mixed $aud
     */
    public function setAud($aud)
    {
        $this->aud = $aud;
    }

    /**
     * @return mixed
     */
    public function getExp()
    {
        return $this->exp;
    }

    /**
     * @param mixed $exp
     */
    public function setExp($exp)
    {
        $this->exp = $exp;
    }

    /**
     * @return mixed
     */
    public function getNbf()
    {
        return $this->nbf;
    }

    /**
     * @param mixed $nbf
     */
    public function setNbf($nbf)
    {
        $this->nbf = $nbf;
    }

    /**
     * @return mixed
     */
    public function getIat()
    {
        return $this->iat;
    }

    /**
     * @param mixed $iat
     */
    public function setIat($iat)
    {
        $this->iat = $iat;
    }

    /**
     * @return mixed
     */
    public function getJti()
    {
        return $this->jti;
    }

    /**
     * @param mixed $jti
     */
    public function setJti($jti)
    {
        $this->jti = $jti;
    }





    /*
     * @desc get required information and return JWT
     */
    public function encode(){

    }

    /*
     * @desc get header and payload to generate signature
     */
    public function signature(){

    }



}