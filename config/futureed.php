<?php

return [
    'login' => [
        'attempt' => 3
    ],
    'activated' => 1,
    'deleted' => 0,
    'locked' => 0,
    'image_password_count' => 3,
    'image_password_folder' => 'images/password',


    //Request code expiry in seconds
    'request_code_expiry' => 3600,

    //User types
    'admin' => 'Admin',
    'client' => 'Client',
    'student' => 'Student',

    //client types Parent, Principal, Teacher
    'parent' => 'Parent',
    'principal' => 'Principal',
    'teacher' => 'Teacher',
    
    //avatar folder 
    'image_avatar_folder' => 'images/avatar',
    'image_avatar_count' => 5,

    //thumbnial folder
    'thumbnail' =>'images/thumbnail',

    //mail forgot password
    'subject_forgot'   =>  'Forgot Password',
    'subject_forgot_resend' => 'Resending: Forgot Password',

    //mail register
    'subject_register' => 'Welcome to Future Lesson!',
    'subject_reg_resend' => 'Resending: Email Confirmation',

    //new email

    'subject_change_email' => 'Change Email',
    'subject_email_resend' =>  'Resending: Change Email',
    
    'admin_delete_threshold' => 3,
    
	#min and max values
	'username_min' => 8,
	'username_max' => 32,
	'password_min' => 8,
	'password_max' => 32,
	'first_name_max' => 64,
	'last_name_max' => 64,
	
	#client account status 
	'client_account_status_pending' => 'Pending',
	'client_account_status_accepted' => 'Accepted',
	'client_account_status_rejected' => 'Rejected',

    //Default country
    'default_country' => 840, //United States
    
    #Add Student via Teacher.
    'new' => 'New',
    'existing' => 'Existing',
    
    #Payment status
    'pending' => 'Pending',
    'paid' => 'Paid',
    'cancelled' => 'Cancelled',

    //user Status
    'user_disabled' => 'Disabled',
	'user_enabled' => 'Enabled'

];