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

    /*
     * $contents
     * view - views of the email
     * data - data to be passed to view
     * mail_sender - sender
     * mail_sender_name - name of the sender
     * mail_recipient - recipient
     * mail_recipient_name - name of the recipient
     * carbon_copy - emails to be cc'ed
     * cabon_copy_name - name of the cc'ed
     * blind_carbon_copy - emails to be bcc'ed
     * blind_carbon_copy_name - name of the bcc'ed
     * subject - subject of the email
     */
    public function sendMail($contents){

        try{

            Mail::send($contents['view'],$contents['data'],function($message) use ($contents){


                //mail sender
                //TODO: set default to no-reply@company.com
                $message->from($contents['mail_sender'],$contents['mail_sender_name']);

                //mail recipient
                $message->to($contents['mail_recipient'],$contents['mail_recipient_name']);

                //if carbon copy is set.
                if(isset($contents['carbon_copy'])){

                    $message->cc($contents['carbon_copy'],$contents['carbon_copy_name']);

                }

                //if blind carbon copy is set.
                if(isset($contents['blind_carbon_copy'])){

                    $message->bcc($contents['blind_carbon_copy'],$contents['blind_carbon_copy_name']);

                }

                //mail subject
                $message->subject($contents['subject']);

            });


        } catch(Exception $e){
            throw new Exception ($e->getMessage());
        }

    }

    public function studentRegister($user, $code){
        $content = [
            'view' => 'emails.student.confirmation-code',
            'data' => [
                'name' => 'Jason',
                'code' => 1234,
                //TODO: determine where to get the url on the link of the email.
                'link' => url() . '/api/v1',
            ],
            'mail_sender' => 'no-reply@futureed.com',
            'mail_sender_name' => 'Future Lesson',
            'mail_recipient' => 'jmaglangit@nerubia.com',
            'mail_recipient_name' => 'Jason Maglangit',
            'subject' => '[TEST] Student register with a code'
        ];

        $this->sendMail($content);

    }




    public function sendStudentMailResetPassword($id){
        //TODO: Send email with code of password.
        //

    }

}