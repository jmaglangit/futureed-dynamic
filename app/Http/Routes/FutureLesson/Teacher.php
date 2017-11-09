<?php
	/**
	*@return /teacher
	*/
	Routes::group(array(
			'prefix' => 'teacher'
			, 'middleware' => ['client', 'teacher']), function() {

		Routes::get('/', [
			'as' => 'client.teacher.index',
			'uses' => 'FutureLesson\Client\DashboardController@index'
		]);

		Routes::group(['prefix' => 'class'], function(){
			$manage_class_controller = 'FutureLesson\Client\ManageClassController';

			Routes::get('/', [
				'as' => 'client.teacher.class.index',
				'uses' => $manage_class_controller . '@index'
			]);

			Routes::group(['prefix' => 'partials'], function() {
				$manage_class_controller = 'FutureLesson\Client\ManageClassController';

				Routes::get('list_class_form', [
					'as' => 'client.teacher.class.partials.list_class_form',
					'uses' => $manage_class_controller . '@list_class_form'
				]);

				Routes::get('view_class_form', [
					'as' => 'client.teacher.class.partials.view_class_form',
					'uses' => $manage_class_controller . '@view_class_form'
				]);

				Routes::get('edit_class_form', [
					'as' => 'client.teacher.class.partials.edit_class_form',
					'uses' => $manage_class_controller . '@edit_class_form'
				]);

				Routes::get('add_student_form', [
					'as' => 'client.teacher.class.partials.add_student_form',
					'uses' => $manage_class_controller . '@add_student_form'
				]);
			});
		});

		Routes::group(['prefix' => 'student'], function() {
			$manage_teacher_student_controller = 'FutureLesson\Client\ManageTeacherStudentController';

			Routes::get('/', [
				'as' => 'client.teacher.student.index',
				'uses' => $manage_teacher_student_controller . '@index'
			]);

			Routes::group(['prefix' => 'partials'], function() {
				$manage_teacher_student_controller = 'FutureLesson\Client\ManageTeacherStudentController';

				Routes::get('list_student_form', [
					'as' => 'client.teacher.student.partials.list_student_form',
					'uses' => $manage_teacher_student_controller . '@list_student_form'
				]);

				Routes::get('view_student_form', [
					'as' => 'client.teacher.student.partials.view_student_form',
					'uses' => $manage_teacher_student_controller . '@view_student_form'
				]);

				Routes::get('email_student_form', [
					'as' => 'client.teacher.student.partials.email_student_form',
					'uses' => $manage_teacher_student_controller . '@email_student_form'
				]);
			});
		});

		Routes::group(['prefix' => 'tips'], function() {
			$manage_teacher_tips_controller = 'FutureLesson\Client\ManageTeacherTipsController';

			Routes::get('/', [
				'as' => 'client.teacher.tips.index',
				'uses' => $manage_teacher_tips_controller . '@index'
			]);

			Routes::group(['prefix' => 'partials'], function() {
				$manage_teacher_tips_controller = 'FutureLesson\Client\ManageTeacherTipsController';

				Routes::get('list_tips_form', [
					'as' => 'client.teacher.tips.partials.list_tips_form',
					'uses' => $manage_teacher_tips_controller . '@list_tips_form'
				]);

				Routes::get('view_tips_form', [
					'as' => 'client.teacher.tips.partials.view_tips_form',
					'uses' => $manage_teacher_tips_controller . '@view_tips_form'
				]);
			});
		});

		Routes::group(['prefix' => 'help'], function() {
			$manage_teacher_help_controller = 'FutureLesson\Client\ManageTeacherHelpController';

			Routes::get('/', [
				'as' => 'client.teacher.help.index',
				'uses' => $manage_teacher_help_controller . '@index'
			]);

			Routes::group(['prefix' => 'partials'], function() {
				$manage_teacher_help_controller = 'FutureLesson\Client\ManageTeacherHelpController';

				Routes::get('list_help_form', [
					'as' => 'client.teacher.help.partials.list_help_form',
					'uses' => $manage_teacher_help_controller . '@list_help_form'
				]);

				Routes::get('view_help_form', [
					'as' => 'client.teacher.help.partials.view_help_form',
					'uses' => $manage_teacher_help_controller . '@view_help_form'
				]);
			});
		});

		Routes::group(['prefix' => 'help_ans'], function() {
			$manage_teacher_help_ans_controller = 'FutureLesson\Client\ManageTeacherHelpAnswerController';

			Routes::group(['prefix' => 'partials'], function() {
				$manage_teacher_help_ans_controller = 'FutureLesson\Client\ManageTeacherHelpAnswerController';

				Routes::get('list_help_ans_form', [
					'as' => 'client.teacher.help_answer.partials.list_help_ans_form',
					'uses' => $manage_teacher_help_ans_controller . '@list_help_ans_form'
				]);

				Routes::get('view_help_ans_form', [
					'as' => 'client.teacher.help_answer.partials.view_help_ans_form',
					'uses' => $manage_teacher_help_ans_controller . '@view_help_ans_form'
				]);
			});
		});

		Routes::group(['prefix' => 'module'], function() {
			$manage_teacher_module_controller = 'FutureLesson\Client\ManageTeacherModuleController';

			Routes::get('/', [
				'as' => 'client.teacher.module.index',
				'uses' => $manage_teacher_module_controller . '@index'
			]);

			Routes::group(['prefix' => 'partials'], function() {
				$manage_teacher_module_controller = 'FutureLesson\Client\ManageTeacherModuleController';

				Routes::get('list_module_form', [
					'as' => 'client.teacher.module.partials.list_module_form',
					'uses' => $manage_teacher_module_controller . '@list_module_form'
				]);

				Routes::get('view_module', [
					'as' => 'client.teacher.module.partials.view_module',
					'uses' => $manage_teacher_module_controller . '@view_module'
				]);
			});

			Routes::group(['prefix' => 'teaching-content'], function() {
			$manage_teacher_content_controller = 'FutureLesson\Client\ManageTeacherContentController';

				Routes::get('/', [
					'as' => 'client.teacher.teaching_content.index',
					'uses' => $manage_teacher_content_controller . '@index'
				]);

				Routes::get('/{id}', [
					'as' => 'client.teacher.teaching_content.id',
					'uses' => $manage_teacher_content_controller . '@index'
				]);

				Routes::group(['prefix' => 'partials'], function() {
					$manage_teacher_content_controller = 'FutureLesson\Client\ManageTeacherContentController';

					Routes::get('list_content_form', [
						'as' => 'client.teacher.teaching_content.partials.list_content_form',
						'uses' => $manage_teacher_content_controller . '@list_content_form'
					]);
				});
			});

			Routes::group(['prefix' => 'question'], function() {
			$manage_teacher_question_controller = 'FutureLesson\Client\ManageTeacherQuestionController';

				Routes::get('/', [
					'as' => 'client.teacher.question.index',
					'uses' => $manage_teacher_question_controller . '@index'
				]);

				Routes::get('/{id}', [
					'as' => 'client.teacher.question.id',
					'uses' => $manage_teacher_question_controller . '@index'
				]);

				Routes::group(['prefix' => 'partials'], function() {
					$manage_teacher_question_controller = 'FutureLesson\Client\ManageTeacherQuestionController';

					Routes::get('list', [
						'as' => 'client.teacher.question.partials.list',
						'uses' => $manage_teacher_question_controller . '@listview'
					]);
				});
			});
		});

		Routes::group([
			'prefix' => 'reports'
				,'middleware' => 'teacher'], function(){
			Routes::get('/', [
				'as' => 'teacher.reports.index'
				, 'uses' => 'FutureLesson\Client\ManageTeacherReportsController@index'
			]);

			Routes::get('/reports_form', [
				'as' => 'teacher.reports.partials.reports_form'
				, 'uses' => 'FutureLesson\Client\ManageTeacherReportsController@reports_form'
			]);

			Routes::get('/report_card_form', [
				'as' => 'teacher.reports.partials.report_card_form'
				, 'uses' => 'FutureLesson\Client\ManageTeacherReportsController@report_card'
			]);

			Routes::get('/subject_area_form', [
				'as' => 'teacher.reports.partials.subject_area_form'
				, 'uses' => 'FutureLesson\Client\ManageTeacherReportsController@subject_area'
			]);

			Routes::get('/subject_area_heatmap_form', [
				'as' => 'teacher.reports.partials.subject_area_heatmap_form'
				, 'uses' => 'FutureLesson\Client\ManageTeacherReportsController@subject_area_heatmap'
			]);

			Routes::get('/summary_progress_form', [
				'as' => 'teacher.reports.partials.summary_progress_form'
				, 'uses' => 'FutureLesson\Client\ManageTeacherReportsController@summary_progress'
			]);

			Routes::get('/current_learning_form', [
				'as' => 'teacher.reports.partials.current_learning_form'
				, 'uses' => 'FutureLesson\Client\ManageTeacherReportsController@current_learning'
			]);

			Routes::get('/progress_bar', [
				'as' => 'teacher.reports.partials.progress_bar'
				, 'uses' => 'FutureLesson\Client\ManageTeacherReportsController@progress_bar'
			]);

			Routes::get('/question_analysis',[
				'as' => 'teacher.reports.partials.question_analysis'
				, 'uses' => 'FutureLesson\Client\ManageTeacherReportsController@question_analysis'
			]);

			Routes::get('/platform-chart-monthly',[
				'as' => 'teacher.reports.partials.charts.platform-chart-monthly',
				'uses' => 'FutureLesson\Client\ManageTeacherReportsController@platform_chart_monthly'
			]);

			Routes::get('/platform-chart-weekly',[
				'as' => 'teacher.reports.partials.charts.platform-chart-weekly',
				'uses' => 'FutureLesson\Client\ManageTeacherReportsController@platform_chart_weekly'
			]);

			Routes::get('/platform-chart-subject-area',[
				'as' => 'teacher.reports.partials.charts.platform-chart-subject-area',
				'uses' => 'FutureLesson\Client\ManageTeacherReportsController@platform_chart_subject_area'
			]);

			Routes::get('/platform-chart-subject-area-heatmap',[
				'as' => 'teacher.reports.partials.charts.platform-chart-subject-area-heatmap',
				'uses' => 'FutureLesson\Client\ManageTeacherReportsController@platform_chart_subject_area_heatmap'
			]);
		});
	});