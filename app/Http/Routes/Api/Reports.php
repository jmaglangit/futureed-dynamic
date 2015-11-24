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
		'uses' => 'Api\Reports\StudentReportRestController@studentStatusReport',
		'as' => 'api.report.student.status'
	]);

	Routes::get('/student-progress/{id}/{subject_id}',[
		'uses' => 'Api\Reports\StudentReportRestController@studentProgressReport',
		'as' => 'api.report.student.progress'
	]);

	Routes::get('/student-progress/curriculum/{id}/{subject_id}',[
		'uses' => 'Api\Reports\StudentReportRestController@studentSubjectGradeProgressReport',
		'as' => 'api.report.student.progress.curriculum'
	]);

	Routes::get('/student-progress/current-learning/{student_id}/{subject_id}',[
		'uses' => 'Api\Reports\StudentReportRestController@studentCurrentLearning',
		'as' => 'api.report.student.progress.current-learning'
	]);


	/**
	 * Class
	 */
	Routes::get('/classroom/{class_id}',[
		'uses' => 'Api\Reports\ClassReportRestController@classReport',
		'as' => 'api.report.classroom.status'
	]);

	/**
	 * School
	 */
	Routes::get('/school/{school_code}',[
		'uses' => 'Api\Reports\SchoolReportRestController@schoolProgress',
		'as' => 'api.report.school.status'
	]);

	Routes::get('/school/{school_code}/teachers',[
		'uses' => 'Api\Reports\SchoolReportRestController@schoolTeacherProgress',
		'as' => 'api.report.school.teacher.progress'
	]);


	/**
	 * REPORT EXPORTS ============================>
	 */

	/**
	 * Student export
	 */
	Routes::get('/student-progress/curriculum/{id}/{subject_id}/{file_type}',[
			'uses' => 'Api\Reports\StudentReportExportController@studentSubjectGradeProgressReport',
			'as' => 'api.report.student.progress.curriculum'
	]);

	Routes::get('/student-progress/current-learning/{student_id}/{subject_id}/{file_type}',[
			'uses' => 'Api\Reports\StudentReportExportController@studentCurrentLearning',
			'as' => 'api.report.student.progress.current-learning.export'
	]);

	/**
	 * School export
	 */
	Routes::get('/school/{school_code}/{file_type}',[
			'uses' => 'Api\Reports\SchoolReportExportController@schoolProgress',
			'as' => 'api.report.school.status.export'
	]);

	Routes::get('/school/{school_code}/teachers/{file_type}',[
			'uses' => 'Api\Reports\SchoolReportExportController@schoolTeacherProgress',
			'as' => 'api.report.school.teacher.progress.export'
	]);


});