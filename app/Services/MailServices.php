<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/19/15
 * Time: 6:30 PM
 */

namespace FutureEd\Services;


use Illuminate\Mail\Mailer;

class MailServices {

    public function __construct(Mailer $mailer){
        $this->mailer = $mailer;
    }

    public function sendMail(
        $recipient,
        $subject,
        $description,
        $links
    ){

    }

    public function sendStudentMail(){

    }

}