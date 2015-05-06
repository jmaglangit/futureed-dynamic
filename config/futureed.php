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

    //mail forgot password
    'subject_forgot'   =>  'Forgot Password',
    'subject_forgot_resend' => 'Resending: Forgot Password',

    //mail register
    'subject_register' => 'Welcome to Future Lesson!',
    'subject_reg_resend' => 'Resending: Email Confirmation',

    //new email

    'subject_change_email' => 'Change Email',
    'subject_email_resend' =>  'Resending: Change Email',

];