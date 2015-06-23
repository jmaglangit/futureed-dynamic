<?php
/**
 * @desc set constants for JWT variable requirements.
 *
 * iss: The issuer of the token
sub: The subject of the token
aud: The audience of the token
exp: Token expiration time defined in Unix time
nbf: “Not before” time that identifies the time before which the JWT must not be accepted for processing
iat: “Issued at” time, in Unix time, at which the token was issued
jti: JWT ID claim provides a unique identifier for the JWT
 */
Return [


    'iss' => env('TOKEN_ISS','futureed.com'),
    'sub' => env('TOKEN_SUB','access token'),
    'aud' => env('TOKEN_AUD','user'),

    //set token time expiry
    'exp' => env('TOKEN_EXP',60),

    'nbf ' => time(),
    'iat' => time(),
    'jti' => env('TOKEN_JTI','FutureEd'),

    /*
     * JWT default header
     */
    'alg' => 'sha1',
    'typ' => 'JWT',

    /*
     * JWT deafault claims
     */
    'site' => env('TOKEN_SITE','futureed.com'),
    'company' => env('TOKEN_COMPANY','Company'),
    'app' => env('TOKEN_APP','FutureEd'),
    'admin' => true,

	/*
	 * JWT KEY
	 */
	'key' => env('JWT_SECRET','futureed'),

];