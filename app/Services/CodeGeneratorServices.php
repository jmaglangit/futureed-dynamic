<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 4/8/15
 * Time: 4:36 PM
 */

namespace FutureEd\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class CodeGeneratorServices {

    /*
     * Generates codes for
     */



    //Generate code for 4 digits
    public function getCode(){

        $exclude = ['1111','2222','3333','4444','5555','6666','7777','8888','9999'];

        do{

            $code = mt_rand(1111,9999);

        }while(in_array($code,$exclude));

        return $code;

    }

    //generate code with expiry
    public function getCodeExpiry(){
        //get constants for code expiry
        $code_expiry = config('futureed');

        $expires = Carbon::now()->addSeconds($code_expiry['request_code_expiry']);

        return [
            'confirmation_code' => $this->getCode(),
            'confirmation_code_expiry' => $expires->toDateTimeString()
        ];
    }

    public function codeGenerator(){

        $code = Carbon::now()->timestamp;

        return $code;
    }


}