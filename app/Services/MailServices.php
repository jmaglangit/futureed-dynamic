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

    public function sendStudentRegister($user_id){
        $user_type = config('futureed.student');


        //get user information for the email
        $user_detail = $this->user->getUser($user_id,$user_type);

        $code = $this->user->getConfirmationCode($user_id);

        $content = [
            'view' => 'emails.student.registration-email',
            'data' => [
                'name' => $user_detail['name'],
                'code' => $code['confirmation_code'],
                'link' => url() . '/student/email/confirm?email=' . $user_detail['email']  ,
            ],
            'mail_recipient' => $user_detail['email'],
            'mail_recipient_name' => $user_detail['first_name' ] . $user_detail['last_name'],
            'subject' => 'Welcome to Future Lesson!'
        ];
        $this->sendMail($content);
    }

    public function resendStudentRegister($data,$code,$subject){

        $content = [
            'view' => 'emails.student.registration-email',
            'data' => [
                'name' => $data['name'],
                'code' => $code,
                'link' => url() . '/student/email/confirm?email=' . $data['email']  ,
            ],
            'mail_recipient' => $data['email'],
            'mail_recipient_name' => $data['name' ],
            'subject' => $subject
        ];
        $this->sendMail($content);
    }

    public function resendClientRegister($data,$code,$subject){

        $content = [
            'view' => 'emails.client.registration-email',
            'data' => [
                'name' => $data['name'],
                'code' => $code,
                'link' => url() . '/client/email/confirm?email=' . $data['email']  ,
            ],
            'mail_recipient' => $data['email'],
            'mail_recipient_name' => $data['name' ],
            'subject' => $subject
        ];
        $this->sendMail($content);
    }


    public function sendStudentMailResetPassword($data,$code,$subject){
        $content = [
            'view' => 'emails.student.forget-password',
            'data' => [
                'name' => $data['username'],
                'code' => $code,
                'link' => url() . '/student/password/reset?email='.$data['email'],
            ],
            'mail_sender' => 'no-reply@futureed.com',
            'mail_sender_name' => 'Future Lesson',
            'mail_recipient' => 'jsuizo@nerubia.com',
            'mail_recipient_name' =>$data['username'] ,
            'subject' => $subject
        ];
        $this->sendMail($content);
    }

    public function sendClientMailResetPassword($data,$code,$subject){
        $content = [
            'view' => 'emails.client.forget-password',
            'data' => [
                'name' => $data['username'],
                'code' => $code,
                'link' => url() . '/client/password/reset?email='.$data['email'],
            ],
            'mail_sender' => 'no-reply@futureed.com',
            'mail_sender_name' => 'Future Lesson',
            'mail_recipient' => $data['email'],
            'mail_recipient_name' =>$data['username'] ,
            'subject' => $subject
        ];
        $this->sendMail($content);
    }

    public function sendAdminMailResetPassword($data,$code,$subject){
        $content = [
            'view' => 'emails.admin.forget-password',
            'data' => [
                'name' => $data['username'],
                'code' => $code,
                'link' => url() . '/admin/password/reset?email='.$data['email'],
            ],
            'mail_sender' => 'no-reply@futureed.com',
            'mail_sender_name' => 'Future Lesson',
            'mail_recipient' => $data['email'],
            'mail_recipient_name' =>$data['username'] ,
            'subject' => $subject
        ];
        $this->sendMail($content);
    }

}