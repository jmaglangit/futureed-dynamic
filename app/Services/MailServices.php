<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/19/15
 * Time: 6:30 PM
 */

namespace FutureEd\Services;


use Illuminate\Mail\Mailer;
use League\Flysystem\Exception;

class MailServices {

    public function __construct(Mailer $mailer){
        $this->mailer = $mailer;
    }

    //
    public function sendMail($data){
        try{

        } catch(Exception $e){
            throw new Exception ($e->getMessage());
        }

    }

    public function sendStudentMail($id){

    }

}