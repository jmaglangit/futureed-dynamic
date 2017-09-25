<?php	
	Routes::get('/', 'FutureLesson\Student\LoginController@index');

	Routes::group(['prefix' => '/student'], function()
	{
		Routes::get('/', 'FutureLesson\Student\LoginController@index');

		Routes::get('/registration', [
				'as' => 'student.registration'
				, 'uses' => 'FutureLesson\Student\LoginController@registration'
			]);
		Routes::get('/register/confirm', [
				'as' => 'student.register.confirm'
				, 'uses' => 'FutureLesson\Student\LoginController@registration'
			]);
		Routes::get('/email/confirm', [
			'as' => 'student.email.confirm'
			, 'uses' => 'FutureLesson\Student\ProfileController@enter_email_code'
			]);
		Routes::get('/password/forgot', [
				'as' => 'student.password.forgot'
				, 'uses' => 'FutureLesson\Student\LoginController@forgot_password'
			]);
		Routes::get('/logout', [ 
				'as' => 'student.logout'
				, 'uses' => 'FutureLesson\Student\LoginController@logout'
			]);
		Routes::post('/update-user-session', [ 
				'as' => 'student.update_user_session'
				, 'uses' => 'FutureLesson\Student\ProfileController@update_session'
			]);
		
		Routes::group([
			  'prefix' => '/login'], function()
		{
			Routes::get('/', [ 
					'as' => 'student.login'
					, 'uses' => 'FutureLesson\Student\LoginController@index'
				]);
			Routes::post('/', [ 
					'as' => 'student.post.login'
					, 'uses' => 'FutureLesson\Student\LoginController@post_index'
				]);
			Routes::post('/process', [ 
					'as' => 'student.login.process'
					, 'uses' => 'FutureLesson\Student\LoginController@process'
				]);
			Routes::get('/forgot-password', [ 
					'as' => 'student.login.forgot_password'
					, 'uses' => 'FutureLesson\Student\LoginController@forgot_password'
				]);

			Routes::get('/enter-reset-code', [ 
					'as' => 'student.login.password.enter_reset_code'
					, 'uses' => 'FutureLesson\Student\LoginController@enter_reset_code'
				]);

			Routes::post('/reset-password', [ 
					'as' => 'student.login.reset_password'
					, 'uses' => 'FutureLesson\Student\LoginController@reset_password'
				]);
			
			Routes::post('/set-password', [ 
					'as' => 'student.login.set_password'
					, 'uses' => 'FutureLesson\Student\LoginController@set_password'
				]);

			Routes::get('/confirm-media', [ 
					'as' => 'student.login.confirm_media'
					, 'uses' => 'FutureLesson\Student\LoginController@confirm_media'
				]);

			Routes::get('/enter-password', [ 
					'as' => 'student.login.enter_password'
					, 'uses' => 'FutureLesson\Student\LoginController@enter_password'
				]);

			Routes::get('/index-form', [ 
					'as' => 'student.login.index_form'
					, 'uses' => 'FutureLesson\Student\LoginController@index_form'
				]);

			Routes::get('/registration-form', [ 
					'as' => 'student.login.registration_form'
					, 'uses' => 'FutureLesson\Student\LoginController@registration_form'
				]);

			Routes::get('/registration-success', [ 
					'as' => 'student.login.registration_success'
					, 'uses' => 'FutureLesson\Student\LoginController@registration_success'
				]);

			Routes::get('/privacy-policy',[
				'as' => 'student.login.privacy-policy'
				, 'uses' => 'FutureLesson\Student\LoginController@privacy_policy'
			]);

			Routes::get('/resend_confirmation', [
				'as' => 'student.login.resend_confirmation'
				, 'uses' => 'FutureLesson\Student\LoginController@resend_confirmation'
			]);
		});

		Routes::group([
			  'prefix' => '/dashboard'
			, 'middleware' => 'student'], function()
		{
			Routes::get('/', [ 
					'as' => 'student.dashboard.index'
					, 'uses' => 'FutureLesson\Student\DashboardController@index'
				]);
			Routes::get('/follow-up-registration', [ 
					'as' => 'student.dashboard.follow_up_registration'
					, 'uses' => 'FutureLesson\Student\DashboardController@follow_up_registration'
				]);
			Routes::get('/messages',[
					'as' => 'student.dashboard.message',
					'uses' => 'FutureLesson\Student\DashboardController@messages'
				]);
		});

		Routes::group([
			  'prefix' => '/class'
			, 'middleware' => 'student'], function()
		{
			Routes::get('/', [ 
					'as' => 'student.class.index'
					, 'uses' => 'FutureLesson\Student\ClassController@index'
				]);

			Routes::get('/{id}', [ 
					'uses' => 'FutureLesson\Student\ClassController@index'
				]);

			Routes::group([
				  'prefix' => '/partials'
				, 'middleware' => 'student_partial'], function()
			{
				Routes::get('/dashbrd-side-nav', [ 
						'as' => 'student.class.partials.dashbrd-side-nav'
						, 'uses' => 'FutureLesson\Student\ClassController@dashbrd_side_nav'
					]);

				Routes::get('/module_list', [ 
						'as' => 'student.class.partials.module_list'
						, 'uses' => 'FutureLesson\Student\ClassController@module_list'
					]);

				Routes::get('/trial_question_list', [
					'as' => 'student.class.partials.trial.module',
					'uses' => 'FutureLesson\Student\ClassController@trial_module'
				]);
			});

			Routes::group([
				  'prefix' => '/module'
				, 'middleware' => 'student_partial'], function()
			{
				Routes::get('trial', [
					'as' => 'student.class.module.trial-index',
					'uses' => 'FutureLesson\Student\ClassModuleController@trial_module'
				]);

				Routes::get('/', [ 
					'as' => 'student.class.module.index'
					, 'uses' => 'FutureLesson\Student\ClassModuleController@index'
				]);

				Routes::get('/{id}', [ 
					'as' => 'student.class.module.view'
					, 'uses' => 'FutureLesson\Student\ClassModuleController@index'
				]);

				
				Routes::group([
					  'prefix' => '/partials'
					, 'middleware' => 'student_partial'], function()
				{
					Routes::get('/add_help', [ 
							'as' => 'student.class.module.partials.add_help'
							, 'uses' => 'FutureLesson\Student\HelpController@add_help'
						]);

					Routes::get('/list_help', [ 
							'as' => 'student.class.module.partials.list_help'
							, 'uses' => 'FutureLesson\Student\HelpController@list_help'
						]);

					Routes::get('/view_help', [ 
							'as' => 'student.class.module.partials.view_help'
							, 'uses' => 'FutureLesson\Student\HelpController@view_help'
						]);

					Routes::get('/add_tip', [ 
							'as' => 'student.class.module.partials.add_tip'
							, 'uses' => 'FutureLesson\Student\TipsController@add_tip'
						]);

					Routes::get('/list_tips', [ 
							'as' => 'student.class.module.partials.list_tips'
							, 'uses' => 'FutureLesson\Student\TipsController@list_tips'
						]);

					Routes::get('/view_tip', [ 
							'as' => 'student.class.module.partials.view_tip'
							, 'uses' => 'FutureLesson\Student\TipsController@view_tip'
						]);

					Routes::get('/code',
						[
							'as'    => 'student.class.module.code.activity',
							'uses'  => 'FutureLesson\Student\ClassModuleController@coding_module'
						]
					);

					Routes::get('/contents', [
						'as' => 'student.class.module.partials.contents'
						, 'uses' => 'FutureLesson\Student\ClassModuleController@contents'
						]);

					Routes::get('/questions', [
						'as' => 'student.class.module.partials.questions'
						, 'uses' => 'FutureLesson\Student\ClassModuleController@questions'
						]);

					Routes::group([
						'prefix' => '/questions/dynamic'
					],function(){

						$route_name = 'student.class.module.partials.questions.dynamic.';
						$route_controller = 'FutureLesson\Student\ClassModuleController';

						Routes::get('/dynamic',[
							'as' => $route_name . 'dynamic'
							,'uses' => $route_controller . '@dynamic'
						]);

						Routes::get('/fib',[
							'as' => $route_name . 'fib'
							,'uses' => $route_controller . '@fib'
						]);

						Routes::get('/steps',[
							'as' => $route_name . 'steps'
							,'uses' => $route_controller . '@steps'
						]);

						Routes::get('/addition',[
							'as' => $route_name . 'addition'
							,'uses' => $route_controller . '@addition'
						]);

						Routes::get('/addition/answer',[
							'as' => $route_name . 'addition.answer'
							,'uses' => $route_controller . '@additionAns'
						]);

						Routes::get('/subtraction',[
							'as' => $route_name . 'subtraction'
							,'uses' => $route_controller . '@subtraction'
						]);

						Routes::get('/subtraction/answer',[
							'as' => $route_name . 'subtraction.answer'
							,'uses' => $route_controller . '@subtractionAns'
						]);

						Routes::get('/multiplication',[
							'as' => $route_name . 'multiplication'
							,'uses' => $route_controller . '@multiplication'
						]);

						Routes::get('/multiplication/answer',[
							'as' => $route_name . 'multiplication.answer'
							,'uses' => $route_controller . '@multiplicationAns'
						]);

						Routes::get('/division',[
							'as' => $route_name . 'division'
							,'uses' => $route_controller . '@division'
						]);

						Routes::get('/division/answer',[
							'as' => $route_name . 'division.answer'
							,'uses' => $route_controller . '@divisionAns'

						]);
						Routes::get('/fraction-addition',[
							'as' => $route_name . 'fraction-addition'
							,'uses' => $route_controller . '@fraction_addition'
						]);

						Routes::get('/fraction-addition/answer',[
							'as' => $route_name . 'fraction-addition.answer'
							,'uses' => $route_controller . '@fraction_addition_answer'
						]);

						Routes::get('/fraction-addition-whole',[
							'as' => $route_name . 'fraction-addition-whole'
							,'uses' => $route_controller . '@fraction_addition_whole'
						]);

						Routes::get('/fraction-addition-whole/answer',[
							'as' => $route_name . 'fraction-addition-whole.answer'
							,'uses' => $route_controller . '@fraction_addition_whole_answer'
						]);

						Routes::get('/fraction-subtraction',[
							'as' => $route_name . 'fraction-subtraction'
							,'uses' => $route_controller . '@fraction_subtraction'
						]);

						Routes::get('/fraction-subtraction/answer',[
							'as' => $route_name . 'fraction-subtraction.answer'
							,'uses' => $route_controller . '@fraction_subtraction_answer'
						]);

						Routes::get('/fraction-subtraction-butterfly',[
							'as' => $route_name . 'fraction-subtraction-butterfly'
							,'uses' => $route_controller . '@fraction_subtraction_butterfly'
						]);

						Routes::get('/fraction-subtraction-butterfly/answer',[
							'as' => $route_name . 'fraction-subtraction-butterfly.answer'
							,'uses' => $route_controller . '@fraction_subtraction_butterfly_answer'
						]);

						Routes::get('/fraction-division',[
							'as' => $route_name . 'fraction-division'
							,'uses' => $route_controller . '@fraction_division'
						]);

						Routes::get('/fraction-division/answer',[
							'as' => $route_name . 'fraction-division.answer'
							,'uses' => $route_controller . '@fraction_division_answer'
						]);

						Routes::get('/fraction-multiplication',[
							'as' => $route_name . 'fraction-multiplication'
							,'uses' => $route_controller . '@fraction_multiplication'
						]);

						Routes::get('/fraction-multiplication/answer',[
							'as' => $route_name . 'fraction-multiplication.answer'
							,'uses' => $route_controller . '@fraction_multiplication_answer'
						]);

						Routes::get('/fraction-addition-butterfly',[
							'as' => $route_name . 'fraction-addition-butterfly'
							,'uses' => $route_controller . '@fraction_addition_butterfly'
						]);

						Routes::get('/fraction-addition-butterfly/answer',[
							'as' => $route_name . 'fraction-addition-butterfly.answer'
							,'uses' => $route_controller . '@fraction_addition_butterfly_ans'
						]);

						Routes::get('/fraction-subtraction-whole',[
							'as' => $route_name . 'fraction-subtraction-whole'
							,'uses' => $route_controller . '@fraction_subtraction_whole'
						]);

						Routes::get('/fraction-subtraction-whole/answer',[
							'as' => $route_name . 'fraction-subtraction-whole.answer'
							,'uses' => $route_controller . '@fraction_subtraction_whole_answer'
						]);

						Routes::get('/integer-addition',[
							'as' => $route_name . 'integer-addition'
							,'uses' => $route_controller . '@integer_addition'
						]);

						Routes::get('/integer-convert-number',[
							'as' => $route_name . 'integer-convert-number'
							,'uses' => $route_controller . '@integer_convert_number'
						]);

						Routes::get('/integer-sort-small',[
							'as' => $route_name . 'integer-sort-small'
							,'uses' => $route_controller . '@integer_sort_small'
						]);

						Routes::get('/integer-sort-large',[
							'as' => $route_name . 'integer-sort-large'
							,'uses' => $route_controller . '@integer_sort_large'
						]);

						Routes::get('/integer-expanded-decimal',[
							'as' => $route_name . 'integer-expanded-decimal'
							,'uses' => $route_controller . '@integer_expanded_decimal'
						]);

						Routes::get('/integer-decimal',[
							'as' => $route_name . 'integer-decimal'
							,'uses' => $route_controller . '@integer_decimal'
						]);

						Routes::get('/integer-extended',[
							'as' => $route_name . 'integer-extended'
							,'uses' => $route_controller . '@integer_extended'
						]);

						Routes::get('/integer-counting',[
							'as' => $route_name . 'integer-counting'
							,'uses' => $route_controller . '@integer_counting'
						]);

						Routes::get('/integer-identify',[
							'as' => $route_name . 'integer-identify'
							,'uses' => $route_controller . '@integer_identify'
						]);

						Routes::get('/integer-rounding-number',[
							'as' => $route_name . 'integer-rounding-number'
							,'uses' => $route_controller . '@integer_rounding_number'
						]);

						Routes::get('/integer-regroup',[
							'as' => $route_name . 'integer-regroup'
							,'uses' => $route_controller . '@integer_regroup'
						]);

						Routes::get('/decimal-compare',[
							'as' => $route_name . 'decimal-compare'
							,'uses' => $route_controller . '@decimal_compare'
						]);

						Routes::get('/decimal-addition',[
							'as' => $route_name . 'decimal-addition'
							,'uses' => $route_controller . '@decimal_addition'
						]);

						Routes::get('/decimal-numeric',[
							'as' => $route_name . 'decimal-numeric'
							,'uses' => $route_controller . '@decimal_numeric'
						]);

						Routes::get('/decimal-understand',[
							'as' => $route_name . 'decimal-understand'
							,'uses' => $route_controller . '@decimal_understand'
						]);

						Routes::get('/decimal-words',[
							'as' => $route_name . 'decimal-words'
							,'uses' => $route_controller . '@decimal_words'
						]);

					});

					Routes::get('/trial/questions', [
						'as' => 'student.class.module.partials.trial.questions',
						'uses' => 'FutureLesson\Student\ClassModuleController@trial_module_question_list'
					]);

					Routes::get('/messages', [
						'as' => 'student.class.module.partials.view_question_message'
						, 'uses' => 'FutureLesson\Student\ClassModuleController@view_question_message'
						]);

					Routes::get('/notepad',[
						'as' => 'student.class.module.partials.notepad',
						'uses' => 'FutureLesson\Student\ClassModuleController@notepad'
					]);
				});
			});
		});
	
		Routes::group([
			  'prefix' => '/payment'
			, 'middleware' => 'student'], function()
		{
			Routes::get('/', [ 
					'as' => 'student.payment.index'
					, 'uses' => 'FutureLesson\Student\PaymentController@index'
				]);

			Routes::get('/success', [ 
					'as' => 'student.payment.success'
					, 'uses' => 'FutureLesson\Student\PaymentController@success'
				]);

			Routes::get('/fail', [ 
					'as' => 'student.payment.fail'
					, 'uses' => 'FutureLesson\Student\PaymentController@fail'
				]);

			Routes::group([
				  'prefix' => '/partials'
				, 'middleware' => 'student'], function()
			{
				Routes::get('/list', [ 
						'as' => 'student.payment.partials.list'
						, 'uses' => 'FutureLesson\Student\PaymentController@list_form'
					]);

				Routes::get('/add', [ 
						'as' => 'student.payment.partials.add'
						, 'uses' => 'FutureLesson\Student\PaymentController@add_form'
					]);

				Routes::get('/subscribe', [
					'as' => 'student.payment.partials.subscribe'
					, 'uses' => 'FutureLesson\Student\PaymentController@subscription'
				]);

				Routes::get('/view', [ 
						'as' => 'student.payment.partials.view'
						, 'uses' => 'FutureLesson\Student\PaymentController@view_form'
					]);
			});
		});

		Routes::group([
			  'prefix' => '/tips'
			, 'middleware' => 'student'], function()
		{
			Routes::get('/', [ 
					'as' => 'student.tips.index'
					, 'uses' => 'FutureLesson\Student\TipsController@index'
				]);

			Routes::get('/{class_id}', [ 
					'as' => 'student.tips.class'
					, 'uses' => 'FutureLesson\Student\TipsController@index'
				]);

			Routes::post('/', [ 
					'as' => 'student.tips.post.index'
					, 'uses' => 'FutureLesson\Student\TipsController@index'
				]);

			Routes::post('/{class_id}', [ 
					'as' => 'student.tips.post.class'
					, 'uses' => 'FutureLesson\Student\TipsController@index'
				]);

			Routes::group([
				  'prefix' => '/partials'
				, 'middleware' => 'student'], function()
			{
				Routes::get('/list', [ 
						'as' => 'student.tips.partials.list'
						, 'uses' => 'FutureLesson\Student\TipsController@list_form'
					]);

				Routes::get('/detail', [ 
						'as' => 'student.tips.partials.detail'
						, 'uses' => 'FutureLesson\Student\TipsController@detail_form'
					]);
			});
		});

		Routes::group([
			  'prefix' => '/help'
			, 'middleware' => 'student'], function()
		{
			Routes::get('/', [ 
					'as' => 'student.help.index'
					, 'uses' => 'FutureLesson\Student\HelpController@index'
				]);

			Routes::get('/{class_id}', [ 
					'as' => 'student.help.class'
					, 'uses' => 'FutureLesson\Student\HelpController@index'
				]);

			Routes::post('/', [ 
					'as' => 'student.help.post.index'
					, 'uses' => 'FutureLesson\Student\HelpController@index'
				]);

			Routes::post('/{class_id}', [ 
					'as' => 'student.help.post.class'
					, 'uses' => 'FutureLesson\Student\HelpController@index'
				]);

			Routes::group([
				  'prefix' => '/partials'
				, 'middleware' => 'student'], function()
			{
				Routes::get('/list', [ 
						'as' => 'student.help.partials.list'
						, 'uses' => 'FutureLesson\Student\HelpController@list_form'
					]);

				Routes::get('/detail', [ 
						'as' => 'student.help.partials.detail'
						, 'uses' => 'FutureLesson\Student\HelpController@detail_form'
					]);
			});
		});

		Routes::group([
			  'prefix' => 'profile'
			, 'middleware' => 'student'], function()
		{
			Routes::get('/', [ 
					'as' => 'student.profile.index'
					, 'uses' => 'FutureLesson\Student\ProfileController@index'
				]);

			Routes::group(['prefix' => 'partials'], function() {
				Routes::get('/profile_form', [
						'as' => 'student.partials.profile_form'
						, 'uses' => 'FutureLesson\Student\ProfileController@profile_form'
					]);
				Routes::get('/edit_email_form', [
						'as' => 'student.partials.edit_email_form'
						, 'uses' => 'FutureLesson\Student\ProfileController@edit_email_form'
					]);
				Routes::get('/confirm_email_form', [
						'as' => 'student.partials.confirm_email_form'
						, 'uses' => 'FutureLesson\Student\ProfileController@confirm_email_form'
					]);
				Routes::get('/rewards_form', [
						'as' => 'student.partials.rewards_form'
						, 'uses' => 'FutureLesson\Student\ProfileController@rewards_form'
					]);
				Routes::get('/avatar_form', [
						'as' => 'student.partials.avatar_form'
						, 'uses' => 'FutureLesson\Student\ProfileController@avatar_form'
					]);
				Routes::get('/change_password_form', [
						'as' => 'student.partials.change_password_form'
						, 'uses' => 'FutureLesson\Student\ProfileController@change_password_form'
					]);
				Routes::get('/avatar_accessory_form', [
						'as' => 'student.partials.avatar_accessory_form'
						, 'uses' => 'FutureLesson\Student\ProfileController@avatar_accessory_form'
					]);
				Routes::get('/settings',[
					'as' => 'student.partials.settings'
					, 'uses' => 'FutureLesson\Student\ProfileController@settings'
				]);
				Routes::get('/games',[
					'as' => 'student.partials.games_list',
					'uses' => 'FutureLesson\Student\ProfileController@games'
				]);
				Routes::get('/play-game',[
					'as' => 'student.partials.play-game',
					'uses' => 'FutureLesson\Student\ProfileController@play_game'
				]);
				Routes::get('/play-game-messages',[
					'as' => 'student.partials.play-game-messages',
					'uses' => 'FutureLesson\Student\ProfileController@play_game_message'
				]);

			});
		});

		Routes::group([
			  'prefix' => 'learning-style'
			, 'middleware' => 'student'], function()
		{
			Routes::get('/', [ 
					'as' => 'student.learning-style.index'
					, 'uses' => 'FutureLesson\Student\LearningStyleController@index'
				]);

			
		});

		Routes::group([
				'prefix' => 'reports'
				,'middleware' => 'student'], function(){
					Routes::get('/', [
						'as' => 'student.reports.index'
						, 'uses' => 'FutureLesson\Student\ReportsController@index'
					]);

					Routes::get('/reports_form', [
						'as' => 'reports.partials.reports_form'
						, 'uses' => 'FutureLesson\Student\ReportsController@reports_form'
					]);

					Routes::get('/report_card_form', [
						'as' => 'reports.partials.report_card_form'
						, 'uses' => 'FutureLesson\Student\ReportsController@report_card'
					]);

					Routes::get('/subject_area_form', [
						'as' => 'reports.partials.subject_area_form'
						, 'uses' => 'FutureLesson\Student\ReportsController@subject_area'
					]);

					Routes::get('/subject_area_heatmap_form', [
						'as' => 'reports.partials.subject_area_heatmap_form'
						, 'uses' => 'FutureLesson\Student\ReportsController@subject_area_heatmap'
					]);

					Routes::get('/summary_progress_form', [
						'as' => 'reports.partials.summary_progress_form'
						, 'uses' => 'FutureLesson\Student\ReportsController@summary_progress'
					]);

					Routes::get('/current_learning_form', [
						'as' => 'reports.partials.current_learning_form'
						, 'uses' => 'FutureLesson\Student\ReportsController@current_learning'
					]);

					Routes::get('/progress_bar', [
						'as' => 'reports.partials.progress_bar'
						, 'uses' => 'FutureLesson\Student\ReportsController@progress_bar'
					]);

					Routes::get('/question_analysis',[
						'as' => 'reports.partials.question_analysis'
						, 'uses' => 'FutureLesson\Student\ReportsController@question_analysis'
					]);

					Routes::get('/platform-chart-monthly',[
						'as' => 'reports.partials.charts.platform-chart-monthly',
						'uses' => 'FutureLesson\Student\ReportsController@platform_chart_monthly'
					]);

					Routes::get('/platform-chart-weekly',[
						'as' => 'reports.partials.charts.platform-chart-weekly',
						'uses' => 'FutureLesson\Student\ReportsController@platform_chart_weekly'
					]);

					Routes::get('/platform-chart-subject-area',[
						'as' => 'reports.partials.charts.platform-chart-subject-area',
						'uses' => 'FutureLesson\Student\ReportsController@platform_chart_subject_area'
					]);

					Routes::get('/platform-chart-subject-area-heatmap',[
						'as' => 'reports.partials.charts.platform-chart-subject-area-heatmap',
						'uses' => 'FutureLesson\Student\ReportsController@platform_chart_subject_area_heatmap'
					]);
				});

		Routes::group(['prefix' => 'partials'], function() {
			Routes::get('/base_url', [
					'as' => 'student.partials.base_url'
					, 'uses' => 'FutureLesson\Student\LoginController@base_url'
				]);
			Routes::get('/tips_help_bar', [
					'as' => 'student.partials.tips_help_bar'
					, 'uses' => 'FutureLesson\Student\LoginController@tips_help_bar'
				]);
			});
	});
?>