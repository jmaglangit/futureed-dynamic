<?php


Routes::group([
	'prefix' => '/dashboard',
//	'middleware' => ['api_user', 'api_after'],
//	'permission' => ['admin', 'client', 'student'],
//	'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
], function () {

	/**
	 * Student
	 */
	Routes::get('/student/{id}',[
		'uses' => 'Api\Reports\StudentReportRestController@studentStatusReport',
		'as' => 'api.dashboard.student.status'
	]);

	Routes::get('/student-progress/{id}/{subject_id}',[
		'uses' => 'Api\Reports\StudentReportRestController@studentProgressReport',
		'as' => 'api.dashboard.student.progress'
	]);

	Routes::get('/student-progress/curriculum/{id}/{subject_id}',[
		'uses' => 'Api\Reports\StudentReportRestController@studentSubjectGradeProgressReport',
		'as' => 'api.dashboard.student.progress.curriculum'
	]);

	Routes::get('/student-progress/current-learning/{student_id}/{subject_id}',[
		'uses' => 'Api\Reports\StudentReportRestController@studentCurrentLearning',
		'as' => 'api.dashboard.student.progress.current-learning'
	]);


	/**
	 * Class
	 */
	Routes::get('/classroom/{class_id}',[
		'uses' => 'Api\Reports\ClassReportRestController@classReport',
		'as' => 'api.dashboard.classroom.status'
	]);

	/**
	 * School
	 */
	Routes::get('/school/{school_code}',[
		'uses' => 'Api\Reports\SchoolReportRestController@schoolProgress',
		'as' => 'api.dashboard.school.status'
	]);

	Routes::get('/school/{school_code}/teachers',[
		'uses' => 'Api\Reports\SchoolReportRestController@schoolTeacherProgress',
		'as' => 'api.dashboard.school.teacher.progress'
	]);


	/**
	 * REPORT EXPORTS ============================>
	 */

	/**
	 * Student export
	 */
	Routes::get('/student-progress/curriculum/{id}/{subject_id}/{file_type}',[
			'uses' => 'Api\Reports\StudentReportExportController@studentSubjectGradeProgressReport',
			'as' => 'api.dashboard.student.progress.curriculum'
	]);

	Routes::get('/student-progress/current-learning/{student_id}/{subject_id}/{file_type}',[
			'uses' => 'Api\Reports\StudentReportExportController@studentCurrentLearning',
			'as' => 'api.dashboard.student.progress.current-learning.export'
	]);




});