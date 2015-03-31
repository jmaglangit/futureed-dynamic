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


    'iss' => 'www.futureed.com',
    'sub' => 'access token',
    'aud' => 'user',

    //set token time expiry
    'exp' => 60,

    'nbf ' => time(),
    'iat' => time(),
    'jti' => 'FutureEd',

    /*
     * JWT default header
     */
    'alg' => 'sha1',
    'typ' => 'JWT',

    /*
     * JWT deafault claims
     */
    'site' => 'www.futureed.com',
    'company' => 'FutureEd',
    'app' => 'Future Lessons',
    'admin' => true,


];