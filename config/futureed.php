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
	'enabled' => 'Enabled',
	'disabled' => 'Disabled',
	'active' => 'Active',
	'inactive' => 'Inactive',
	'pending' => 'Pending',
	'accepted' => 'Accepted',
	'rejected' => 'Rejected',


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
	'thumbnail' => 'images/thumbnail',

	//mail change password
	'subject_change_password' => '{user} Change Password',
	'subject_resend_change_password' => 'Resending: {user} Change Password',

	//mail forgot password
	'subject_forgot' => '{user} Forgot Password',
	'subject_forgot_resend' => 'Resending: {user} Forgot Password',


	//mail register
	'subject_register' => 'Welcome to Future Lesson!',
	'subject_reg_resend' => 'Resending: {user} Email Confirmation',

	//new email

	'subject_change_email' => '{user} Change Email',
	'subject_email_resend' => 'Resending: {user} Change Email',

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
	'user_enabled' => 'Enabled',

	//order no. zero fill constants
	'client_id_zero_fill' => 4,
	'order_id_zero_fill' => 6,
	'invoice_id_zero_fill' => 10,

	//Parent invite student subject
	'invite_student' => 'You have been invited by a Parent!',

	//set value for link_type
	'link_type_general' => 'General',

    //Help Request Status
    'help_request_status_pending' => 'Pending',
    'help_request_status_accepted' => 'Accepted',
    'help_request_status_rejected' => 'Rejected',

	//for tips take 3
	'tip_take' => 3,

	//for general tips link_type
	'link_type_general' => 'General',

	//for accepted tips tip_status
	'tip_status_accepted' => 'Accepted',

	//tip_rating
	'tip_rating' => 'rating',

	//uploads base path
	'uploads' => base_path(). '/public/uploads',

	//path for question uploaded images temp
	'question_image_path' =>  base_path().'/public/uploads/temp/question',

	//path for question uploaded images final
	'question_image_path_final' => base_path().'/public/uploads/question',
	'question_image_path_final_public' => '/uploads/question',

	//question
	'question' => 'question',

	//path for answer uploaded images temp
	'answer_image_path' =>  base_path().'/public/uploads/temp/answer',

	//path for question uploaded images final
	'answer_image_path_final' => base_path().'/public/uploads/answer',
	'answer_image_path_final_public' => '/uploads/answer',

	//answer
	'answer' => 'answer',


	//path for content uploaded images temp
	'content_image_path' =>  base_path().'/public/uploads/temp/content',

	//path for content uploaded images final
	'content_image_path_final' => base_path().'/public/uploads/content',
	'content_image_path_final_public' => '/uploads/content',

	//answer
	'content' => 'content',







    //answer status
    'answer_status_correct' => 'Correct',
    'answer_status_wrong' => 'Wrong',

];