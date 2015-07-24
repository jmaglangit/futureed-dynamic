<?php
	/**
	*@return /teacher
	*/
	Routes::group(array(
			'prefix' => 'teacher'
			, 'middleware' => ['client', 'teacher']), function() {

		$manage_teacher_controller = 'FutureLesson\Client\ManageTeacherController';

		Routes::get('/', [
			'as' => 'client.teacher.index',
			'uses' => $manage_teacher_controller . '@index'
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
		});
	});