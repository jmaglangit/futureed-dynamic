<?php

return [
	//conditions
	'true' => 1,
	'false' => 0,

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
	'none' => 'None',

	//Request code expiry in seconds
	'request_code_expiry' => 3600,

	//User types
	'admin' => 'Admin',
	'client' => 'Client',
	'student' => 'Student',

	//admin types
	'admin_role_admin' => 'Admin',
	'admin_role_super_admin' => 'Super Admin',

	//client types Parent, Principal, Teacher
	'parent' => 'Parent',
	'principal' => 'Principal',
	'teacher' => 'Teacher',

	//avatar folder
	'image_avatar_folder' => 'images/avatar',
	'image_avatar_count' => 5,

	//thumbnail folder
	'thumbnail' => 'images/thumbnail',

	//background image folder
	'image_avatar_background_folder' => 'images/avatar/background_image',

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

	//for accepted tips tip_status
	'tip_status_accepted' => 'Accepted',

	//tip_rating
	'tip_rating' => 'rating',

	//uploads base path
	'uploads' => base_path() . '/public/uploads',

	//path for question uploaded images temp
	'question_image_path' => base_path() . '/public/uploads/temp/question',

	//path for question uploaded images final
	'question_image_path_final' => base_path() . '/public/uploads/question',
	'question_image_path_final_public' => '/uploads/question',

	//question
	'question' => 'question',

	//path for answer uploaded images temp
	'answer_image_path' => base_path() . '/public/uploads/temp/answer',

	//path for question uploaded images final
	'answer_image_path_final' => base_path() . '/public/uploads/answer',
	'answer_image_path_final_public' => '/uploads/answer',

	//answer
	'answer' => 'answer',

	//Teaching content image
	'teaching_content_image_local' => base_path() . '/public/uploads/content',
	'teaching_content_image_uploads' => '/uploads/content',


	//path for content uploaded images temp
	'content_image_path' => base_path() . '/public/uploads/temp/content',

	//path for content uploaded images final
	'content_image_path_final' => base_path() . '/public/uploads/content',
	'content_image_path_final_public' => '/uploads/content',

	//answer
	'content' => 'content',

	//icons
	'icon' => 'icon',

	//path for icon on uploaded images temp
	'icon_image_path' => base_path() . '/public/uploads/temp/icon',

	//path for icon to uploaded final images
	'icon_image_path_final' => base_path() . '/public/uploads/icon',
	'icon_image_path_final_public' => '/uploads/icon',


	//answer status
	'answer_status_correct' => 'Correct',
	'answer_status_wrong' => 'Wrong',

	//student age guide by parent
	'student_age_guardian' => 13,

	//Student Module
	'module_status_available' => 'Available',
	'module_status_ongoing' => 'On Going',
	'module_status_completed' => 'Completed',
	'module_status_failed' => 'Failed',
	'points_to_finish_module' => 12,
	'deductions_to_fail_module' => 10,

	//Question Types
	'question_type_fill_in_the_blank' => 'FIB',
	'question_type_multiple_choice' => 'MC',
	'question_type_provide_answer' => 'N',
	'question_type_ordering' => 'O',
	'question_type_graph' => 'GR',
	'question_type_quad' => 'QUAD',
	'question_type_coding' => 'COD',

	//Graph setup
	'graph_divisible' => 5,

	'question_difficulty_levels' => [1, 2, 3],
	'question_minimum_count' => 4,

	//MB
	'question_mb' => 1048576,

	//Correct Answer
	'yes' => 'Yes',
	'no' => 'No',
	//Correct flag
	'correct' => 'Y',
	'incorrect' => 'N',
	//MC none
	'mc_none' => 'none',

	//reset module
	'reset_module' => 'Reset Module',

	//student points code
	'student_point_description_code' => 1,
	'student_point_description_code_tip' => 3,
	'student_point_description_code_help' => 4,

	//student points description
	'student_point_description' => 'Completion of Module',
	'student_point_description_tip' => 'Contribute a Tip',
	'student_point_description_help' => 'Contribute an Answer',

	//student progress
	'student_progress' => 100,

	//PAR shortcut for parent
	'PAR' => 'PAR',

	//STU shortcut for Student
	'STU' => 'STU',


	#iAssess IDs for LSP
	'lsp_child_id' => env('IASSESS_LSP_CHILD', 100063),
	'lsp_adult_id' => env('IASSESS_LSP_ADULT', 100064),
	'lsp_for_adult_age' => env('IASSESS_LSP_ADULT_AGE', 18),
	'lsp_result_name' => env('IASSESS_LSP_RESULT_NAME', 'IPS1'),
	'default_lsp' => env('IASSESS_LSP_DEFAULT', 3),

	//number of years for student to retake LSP
	'lsp_retake_year' => 1,

	//Logs
	'user_log' => 'User',
	'admin_log' => 'Admin',

	//Reports
	'student_excelling' => 'Excelling',
	'student_struggling' => 'Struggling',

	//Reports folder name
	'reports_folder' => 'reports',

	//Reports file type
	'pdf' => 'pdf',
	'xls' => 'xls',
	'mobile-pdf' => 'mobile-pdf',
	'mobile-xls' => 'mobile-xls',

	//Reports color code
	'report_export_style' => [
		'progress_pass' => 81,
		'progress_median_ceil' => 80,
		'progress_median_floor' => 51,
		'progress_fail_ceil' => 50,
		'progress_fail_floor' => 1,
	],

	'report_export_style_subject' => [
		'progress_pass' => 75,
		'progress_above_ave_floor' => 50,
		'progress_above_ave_ceil' => 75,
		'progress_below_ave_floor' => 25,
		'progress_below_ave_ceil' => 50,
		'progress_below_fail_ceil' => 25,
		'progress_below_fail_floor' => 1
	],

	//avatar accessory folder
	'image_avatar_accessory_folder' => 'images/avatar_accessory',

	//background images folder
	'background_images_folder' => 'images/background-images',

	//games images folder
	'game_images_folder' => '/uploads/games',

	'accepted_csv' => [
		'text/csv',
		'application/vnd.ms-excel'
	],

	//Gender
	'gender' => [
		'male' => 'Male',
		'female' => 'Female'
	],

	//Rating Scores
	'rating_1' => 1,
	'rating_2' => 2,
	'rating_3' => 3,
	'rating_4' => 4,
	'rating_5' => 5,
	'rating_points_0' => 0,
	'rating_points_1' => 4,
	'rating_points_2' => 8,
	'rating_points_3' => 12,
	'rating_points_4' => 16,
	'rating_points_5' => 20,
];