<?php


Routes::group([
	'prefix' => '/report',
], function () {

	Routes::group([
//		'middleware' => ['api_user', 'api_after'],
//		'permission' => ['admin', 'client', 'student'],
//		'role' => ['principal', 'teacher', 'parent', 'admin', 'super admin']
	],function(){


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

		Routes::get('/student-progress/curriculum/heat-map/{id}/{subject_id}',[
			'uses' => 'Api\Reports\StudentReportRestController@getSubjectAreaHeatMap',
			'as' => 'api.report.student.progress.curriculum.heat-map'
		]);

		Routes::get('/student-progress/current-learning/{student_id}/{subject_id}',[
			'uses' => 'Api\Reports\StudentReportRestController@studentCurrentLearning',
			'as' => 'api.report.student.progress.current-learning'
		]);

		Routes::get('/student-progress/question-answer-report',[
			'uses' => 'Api\Reports\StudentReportRestController@getStudentQuestionReport',
			'as' => 'api.report.student.progress.question.answer'
		]);

		Routes::get('/student-chart/platform-hours/{student_id}',[
			'uses' => 'Api\Reports\StudentReportRestController@getStudentPlatformHours',
			'as' => 'api.report.student.progress.platform-hours'
		]);

		Routes::get('/student-chart/platform-week-hours/{student_id}',[
			'uses' => 'Api\Reports\StudentReportRestController@getStudentPlatformHoursWeek',
			'as' => 'api.report.student.progress.platform-week-hours'
		]);

		Routes::get('/student-chart/platform-subject-area-completed/{student_id}',[
			'uses' => 'Api\Reports\StudentReportRestController@getStudentPlatformSubjectArea',
			'as' => 'api.report.student.progress.platform-subject-area-completed'
		]);

		Routes::get('/student-chart/platform-subject-area-heatmap/{student_id}',[
			'uses' => 'Api\Reports\StudentReportRestController@getStudentPlatformSubjectAreaHeatMap',
			'as' => 'api.report.student.progress.platform-subject-area-heatmap'
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

        Routes::get('/school/{school_code}/teachers/subjects/{grade_level}', [
             'uses' => 'Api\Reports\SchoolReportRestController@schoolTeacherSubjectProgress',
//            'uses' => function($school_code) {
//                return [
//                    'school_code' => $school_code
//                ];
//            },
            'as' => 'api.report.school.teacher.subject.progress'
        ]);
	});


	/**
	 * REPORT EXPORTS ============================>
	 */
	/**
	 * Retrieve Saved file.
	 */
	Routes::get('/{folder_name}',[
		'uses' => 'Api\Reports\ReportFileController@getReportFile',
		'as' => 'api.report.folder.file'
	]);

	/**
	 * Student export
	 */
	Routes::get('/student-progress/curriculum/{id}/{subject_id}/{file_type}',[
			'uses' => 'Api\Reports\StudentReportExportController@studentSubjectGradeProgressReport',
			'as' => 'api.report.student.progress.curriculum'
	]);

	Routes::get('/student-progress/curriculum/heat-map/{id}/{subject_id}/{file_type}',[
		'uses' => 'Api\Reports\StudentReportExportController@getSubjectAreaHeatMap',
		'as' => 'api.report.student.progress.curriculum.heat-map'
	]);

	Routes::get('/student-progress/current-learning/{student_id}/{subject_id}/{file_type}',[
			'uses' => 'Api\Reports\StudentReportExportController@studentCurrentLearning',
			'as' => 'api.report.student.progress.current-learning.export'
	]);

	Routes::get('/student-progress/question-analysis',[
		'uses' => 'Api\Reports\StudentReportExportController@exportStudentQuestionAnalysis',
		'as' => 'api.report.student.progress.question-analysis'
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

	/*
	 * Teacher/Class export
	 */
	Routes::get('/classroom/{class_id}/{file_type}',[
		'uses' => 'Api\Reports\ClassReportExportController@classReport',
		'as' => 'api.report.classroom.status.export'
	]);

	/*
	 * Billing Invoice
	 */
	Routes::get('/billing-invoice/{invoice_id}',[
		'uses' => 'Api\Reports\InvoiceController@getBillingInvoice',
		'as' => 'api.report.billing.invoice'
	]);

});