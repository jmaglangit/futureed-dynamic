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

	/**
	 * @param Mailer $mailer
	 * @param UserServices $user
	 * @param ClientServices $client
	 */
    public function __construct(
		Mailer $mailer,
		UserServices $user,
		ClientServices $client,
		RegistrationTokenServices $registrationTokenServices

	)
	{
		$this->mailer = $mailer;
		$this->user = $user;
		$this->client = $client;
		$this->reg_token = $registrationTokenServices;
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

    public function sendStudentRegister($user_id,$url){

        $user_type = config('futureed.student');


        //get user information for the email
        $user_detail = $this->user->getUser($user_id,$user_type);

        $code = $this->user->getConfirmationCode($user_id);

        $content = [
            'view' => 'emails.student.registration-email',
            'data' => [
                'name' => $user_detail['name'],
                'code' => $code['confirmation_code'],
                'link' => $url . '?email=' . $user_detail['email'],
            ],
            'mail_recipient' => $user_detail['email'],
            'mail_recipient_name' => $user_detail['first_name' ] . $user_detail['last_name'],
            'subject' => config('futureed.subject_register')
        ];
        $this->sendMail($content);
    }

    public function resendStudentRegister($data,$code,$url,$subject){

        $content = [
            'view' => 'emails.student.resendregistration-email',
            'data' => [
                'name' => $data['name'],
                'code' => $code,
                'link' => $url . '?email=' . $data['email'],
            ],
            'mail_recipient' => $data['email'],
            'mail_recipient_name' => $data['name' ],
            'subject' => $subject
        ];
        $this->sendMail($content);
    }

    public function sendClientRegister($data,$code,$url,$send = 0){

        if($send == 1){
            $subject = str_replace('{user}',$data->client_role,config('futureed.subject_reg_resend'));

            $template = 'emails.client.registration-email';

        }else{
            $subject = str_replace('{user}',$data->client_role,config('futureed.subject_register'));

            $template = ($data['client_role'] == 'Parent') ? 'emails.client.register-parent-email' : 'emails.client.register-principal-email';
        }
        
        $content = [
            'view' => $template,
            'data' => [
                'name' => $data['name'],
                'code' => $code,
                'link' => $url . '?email=' . $data['email'],
            ],
            'mail_recipient' => $data['email'],
            'mail_recipient_name' => $data['name' ],
            'subject' => $subject
        ];

        $this->sendMail($content);
    }


    public function sendStudentMailResetPassword($data,$code,$url,$subject){

        $content = [
            'view' => 'emails.student.forget-password',
            'data' => [
                'name' => $data->name,
                'code' => $code,
                'link' => $url . '?email=' . $data->email,
            ],
            'mail_sender' => 'no-reply@futureed.com',
            'mail_sender_name' => 'Future Lesson',
            'mail_recipient' => $data->email,
            'mail_recipient_name' => $data->name,
            'subject' => $subject
        ];
        $this->sendMail($content);
    }

    public function sendClientMailResetPassword($data,$code,$url,$subject){

        $content = [
            'view' => 'emails.client.forget-password',
            'data' => [
                'name' => $data->name,
                'code' => $code,
                'link' => $url . '?email=' .$data->email,
            ],
            'mail_sender' => 'no-reply@futureed.com',
            'mail_sender_name' => 'Future Lesson',
            'mail_recipient' => $data->email,
            'mail_recipient_name' => $data->name ,
            'subject' => $subject
        ];
        $this->sendMail($content);
    }

    public function sendAdminMailResetPassword($data,$code,$url,$subject){
        $content = [
            'view' => 'emails.admin.forget-password',
            'data' => [
                'name' => $data->name,
                'code' => $code,
                'link' => $url . '?email=' . $data->email,
            ],
            'mail_sender' => 'no-reply@futureed.com',
            'mail_sender_name' => 'Future Lesson',
            'mail_recipient' => $data->email,
            'mail_recipient_name' => $data->name ,
            'subject' => $subject
        ];
        $this->sendMail($content);
    }

    public function sendMailChangeEmail($data,$code,$url,$send = 0){

        $template = 'emails.student.change-email';
       
        if($send == 0){
            
            $subject = str_replace('{user}',config('futureed.student'),config('futureed.subject_change_email'));

        }else{

            $subject = str_replace('{user}',config('futureed.student'),config('futureed.subject_email_resend'));
        }
        
        $content = [
            'view' => $template,
            'data' => [
                'name' => $data['name'],
                'code' => $code,
                'link' => $url . '?email=' . $data['new_email'],
            ],
            'mail_recipient' => $data['new_email'],
            'mail_recipient_name' => $data['name' ],
            'subject' => $subject
        ];

        $this->sendMail($content);
    }


    public function sendClientVerification($data,$url){

        $template = 'emails.client.verify-client';

        $content = [
            'view' => $template,
            'data' => [
                'name' => $data['name'],
                'link' => $url
            ],
            'mail_recipient' => $data['email'],
            'mail_recipient_name' => $data['name' ],
            'subject' => 'Your Future Lesson Account has been verified'
        ];

        $this->sendMail($content);


    }


    public function sendClientRejection($data,$url){

        $template = 'emails.client.reject-client';

        $content = [
            'view' => $template,
            'data' => [
                'name' => $data['name'],
                'link' => $url
            ],
            'mail_recipient' => $data['email'],
            'mail_recipient_name' => $data['name' ],
            'subject' => 'Your Future Lesson Account has been rejected'
        ];

        $this->sendMail($content);


    }


    public function sendAdminChangeEmail($data,$url){

		$template = 'emails.admin.change-email';

		$subject = str_replace('{user}', config('futureed.admin'), config('futureed.subject_change_email'));

		$content = [
			'view' => $template,
			'data' => [
				'name' => $data['name'],
				'link' => $url,
				'email' => $data['email'],
				'new_email' => $data['new_email']
			],
			'mail_recipient' => $data['email'],
			'mail_recipient_name' => $data['name'],
			'subject' => $subject
		];

		$this->sendMail($content);



    }


    public function sendAdminChangePassword($data,$new_password){

		$template = 'emails.admin.change-password';

		$subject = str_replace('{user}', $data->admin_role, config('futureed.subject_change_password'));

		$content = [
			'view' => $template,
			'data' => [
				'name' => $data->user->name,
				'new_password' => $new_password
			],
			'mail_recipient' => $data->user->email,
			'mail_recipient_name' => $data->user->name,
			'subject' => $subject
		];

		$this->sendMail($content);



    }

	public function sendMailInviteTeacher($user,$client, $current, $url)
	{

		//generate registration_token
		$token = $this->reg_token->getRegistrationToken($user->email);

		//add token to user
		$this->user->addRegistrationToken($user->id,$token);


		$content = [
			'view' => 'emails.client.invite-teacher',
			'data' => [
				'name' => $user->name,
				'current_user' => $current['first_name'] . " " . $current['last_name'],
				'link' => $url['callback_uri'] . '/' . $client->id . '?registration_token='. $token,
			],
			'mail_recipient' => $user->email,
			'mail_recipient_name' => $user->name,
			'subject' => 'You have been invited to join Future Lesson!'
		];

		$this->sendMail($content);
	}

    public function sendExistingStudentRegister($data)
    {
        $user_type = config('futureed.student');

        //get user information for the email
        $user_detail = $this->user->getUser($data['user_id'],$user_type);
        
        $content = [
            'view' => 'emails.student.existing-student-registration-email',
            'data' => [ 'name'         => $user_detail['name'],
                        'class_name'   => $data['class_name'],
                        'teacher_name' => $data['teacher_name']
            ],
            'mail_recipient' => $user_detail['email'],
            'mail_recipient_name' => $user_detail['first_name' ] . $user_detail['last_name'],
            'subject' => 'You have been invited to join Future Lesson!'
        ];
        $this->sendMail($content);
    }

	public function sendMailInviteStudent($data)
	{
		$user_type = config('futureed.student');

		//get user information for the email
		$user_detail = $this->user->getUser($data['user_id'], $user_type);

		//generate registration_token
		$token = $this->reg_token->getRegistrationToken($user_detail['email']);

		//add token to user
		$this->user->addRegistrationToken($user_detail['id'], $token);

		$content = [
			'view' => 'emails.student.invite-student',
			'data' => [
				'student_name' => $user_detail['name'],
				'teacher_name' => $data['teacher_name'],
				'link' => $data['url'] . '/' . $data['student_id'] . '?registration_token=' . $token,
			],
			'mail_recipient' => $user_detail['email'],
			'mail_recipient_name' => $user_detail['name'],
			'subject' => 'You have been invited to join Future Lesson!'
		];

		$this->sendMail($content);
	}

	/**
	 * Send email teacher registration confirmation.
	 * @param $data
	 */
	public function sendTeacherRegistration($data){

		$code = $this->user->getConfirmationCode($data->user->id);

		$contents = [
			'view' => 'emails.client.register-teacher-email',
			'data' => [
				'name' => $data->user->name,
				'code' => $code->confirmation_code,
				'link' => $data->callback_uri.'?email='.$data->user->email,
			],
			'mail_recipient' => $data->user->email,
			'mail_recipient_name' => $data->user->name,
			'subject' => 'Welcome to Future Lesson!'

		];

		$this->sendMail($contents);
	}

	/**
	 * Send email student with invitation code.
	 * @param $data
	 */

	public function sendParentAddStudent($data,$client_details,$code){


		$contents = [
			'view' => 'emails.student.parent-added-student',
			'data' => [
				'name' => $data['name'],
				'code' => $code,
				'parent_name' => $client_details['first_name'].' '.$client_details['last_name'],
			],
			'mail_recipient' => $data['email'],
			'mail_recipient_name' => $data['username'],
			'subject' => 'Welcome to Future Lesson!'

		];

		$this->sendMail($contents);
	}

    public function sendTeacherAddClass($data){
        $contents = [
            'view' => 'emails.client.invite-teacher-to-teach-class',
            'data' => [
                'name' => $data['name'],
                'school_name' => $data['school_name'],
                'class_name' => $data['class_name'],
                'login_link' => $data['login_link']
            ],
            'mail_recipient' => $data['email'],
            'mail_recipient_name' => $data['username'],
            'subject' => 'Welcome to Future Lesson!'

        ];

        $this->sendMail($contents);
    }


}