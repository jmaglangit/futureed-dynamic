<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/19/15
 * Time: 6:30 PM
 */

namespace FutureEd\Services;


use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use League\Flysystem\Exception;

class MailServices {

    public function __construct(Mailer $mailer, UserServices $user){
        $this->mailer = $mailer;
        $this->user = $user;
    }

    //
    public function sendMail(){
        try{
            dd(csrf_token());

            Mail::send('emails.student.forget-password', array('key' => 'value'), function($message)
            {
                $message->from('do-not-reply@example.com', 'FutureEd');
                $message->to('jmaglangit@nerubia.com', 'John Doe')->subject('Welcome!');


            });

        } catch(Exception $e){
            throw new Exception ($e->getMessage());
        }

    }

    public function sendStudentMailResetPassword($id){
        //TODO: Send email with code of password.

    }

}