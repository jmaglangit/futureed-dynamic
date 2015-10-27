<?php


Routes::group([
	'prefix' => '/report',
//	'middleware' => ['api_user', 'api_after'],
//	'permission' => ['admin', 'client', 'student'],
//	'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
], function () {

	/**
	 * Student
	 */
	Routes::get('/student/{id}',[
		'uses' => 'Api\Reports\StudentReportController@getStudentStatusReport',
		'as' => 'api.report.student.status'
	]);

	Routes::get('/student-progress/{id}/{subject_id}',[
		'uses' => 'Api\Reports\StudentReportController@getStudentProgressReport',
		'as' => 'api.report.student.progress'
	]);

	Routes::get('/student-progress/curriculum/{id}/{subject_id}',[
		'uses' => 'Api\Reports\StudentReportController@getStudentSubjectGradeProgressReport',
		'as' => 'api.report.student.progress.curriculum'
	]);

	Routes::get('/student-progress/current-learning/{student_id}/{subject_id}',[
		'uses' => 'Api\Reports\StudentReportController@getStudentCurrentLearning',
		'as' => 'api.report.student.progress.current-learning'
	]);



});