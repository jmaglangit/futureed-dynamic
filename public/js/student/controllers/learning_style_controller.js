angular.module('futureed.controllers')
	.controller('LearningStyleController', LearningStyleController)
	.directive("testDirective", ['$rootScope', function($rootScope){
	return {
		restrict: 'E',
		link: function(scope, element, attrs) {
			var this_session = {
				log_url: attrs.logUrl,
				post_test_url: attrs.postTestUrl,
				order_candidate_test: {
					id: attrs.orderCandidateTestId
				},
				token: attrs.token,
				user: {
					id: attrs.userId
				},
				test: {
					id: attrs.testId
				}
			};
				
			$rootScope.$broadcast('testReady', this_session);
		}
	};
}]);
	
LearningStyleController.$inject = ['$rootScope', '$scope', '$interval', '$filter', '$sce', '$document', '$window', 'LearningStyleService'];

function LearningStyleController($rootScope, $scope, $interval, $filter, $sce, $document, $window, LearningStyleService) {

	var self = this;
	
	var data_loaded = false;
	
	var order_candidate_test = {};
	
	var now_utc = new Date().toISOString().split('T').join(' ').split('.')[0];
	
	now_utc = new Date(now_utc);

	var start_utc = now_utc;

	var section = {
		getNextPage: function() {
			if ( typeof($scope.session.questions) == 'undefined' ) {
				return 1;
			}
			var next_page =
					$filter('filter')(
						$scope.session.questions,
						{ page_no: $scope.sections[$scope.session.section].page+1 }
					).length ? $scope.sections[$scope.session.section].page+1 : 0;
			return next_page;
		},
		getPageQuestions: function( p ) {
			if ( typeof( p ) == 'undefined' ) {
				var p = $scope.sections[$scope.session.section].page;
			}
			return $filter('filter')($scope.sections[$scope.session.section].questions, { page_no: p, test_section_id: $scope.sections[$scope.session.section].id}, true);
		},
		isFirstPageOfNoIntro: function( p ) {
			if ( typeof( p ) == 'undefined' ) {
				var p = $scope.sections[$scope.session.section].page;
			}
			if ( p == 1 )
			{
				// Pass first question of section's page 1
				return $scope.helpers.isMCQMatrixQuestionWithoutIntro($scope.sections[$scope.session.section].questions[0]);
			}
			return false;
		}
	}

	var checkIncomplete = function() {
		var page_questions = section.getPageQuestions();

		if ( typeof page_questions == 'undefined' ) return;

		$scope.session.incomplete = false;
		for(var i = 0; i < page_questions.length; i++){
			if ( typeof(page_questions[i].user_answers) == 'undefined' ) break;
			if ( page_questions[i].user_answers.length == 0 ) {
				if( parseInt(page_questions[i].is_required) != 0 ){
					$scope.session.incomplete = true;
					i = page_questions.length;
				}
			} else if ( page_questions[i].user_answers.indexOf(null) >= 0 ) {
				if( parseInt(page_questions[i].is_required) != 0 ){
					$scope.session.incomplete = true;
					i = page_questions.length;
				}
			} else {
				for(var j = 0; j < page_questions[i].user_answers.length; j++) {
					if( parseInt(page_questions[i].is_required) != 0 ){
						if ( page_questions[i].user_answers[j].answer_text == null ) {
							$scope.session.incomplete = true;
							break;
						}
					}
				}
			}
		}
	}

	var closeTest = function() {
		$scope.session.next = 'Closing...';
		//TODO: put end test logic here.
		
		window.location.href= '/student/dashboard';
	}

	var enablePreviousPageButton = function() {
		$scope.session.reversible = false;

		// Is the first section
		if ( $scope.session.section == 0 )
		{
			// Must not be the intro page
			$scope.session.reversible = $scope.sections[$scope.session.section].page > 0;
		} else {
			$scope.session.reversible = true;
		}
	}

	var enterEndOfTest = function() {
		$scope.session.next = 'Test completed';
		$scope.session.current_state = 'completed';
	}

	var exitIntroduction = function() {
		setActualTimeLimit();
		$scope.session.current_state = 'sample questions';
		$scope.session.questions = $scope.sections[$scope.session.section].sample_questions;

		// There are no sample questions
		if ( $scope.session.questions.length == 0 )
		{
			gatherActualQuestions();
		}
		setToFirstPage();
	}

	var gatherActualQuestions = function() {
		$scope.session.current_state = 'actual questions';
		$scope.session.ticking = 'taking actual';
		$scope.session.remaining = $scope.session.time_limit_actual;
		$scope.session.questions = $scope.sections[$scope.session.section].questions;
		if ( !$scope.order_candidate_test.started_at )
		{
			startDurationTicker();
			//TODO: put start test here
		}
	}

	var sectionHasNoSampleQuestions

	var setInstructions = function( triggered_by ) {
		$scope.markups.intro = '';
		if ( $scope.helpers.sectionHasStartInstruction($scope.sections[$scope.session.section]) ) {
			$scope.markups.intro = $sce.trustAsHtml($window.marked($scope.sections[$scope.session.section].test_instructions_start));
		}
		if (
			$scope.helpers.sectionHasSamples($scope.sections[$scope.session.section])
			&& $scope.helpers.sectionHasIntroInstruction($scope.sections[$scope.session.section]) ) {
			$scope.markups.intro = $sce.trustAsHtml($window.marked($scope.sections[$scope.session.section].test_instructions_intro));
		}
		if ( $scope.helpers.sectionPageHasInstruction($scope.sections[$scope.session.section]) ) {
			$scope.markups.page = $sce.trustAsHtml($window.marked($scope.sections[$scope.session.section].question_page_instruction));
		}

		if ( !$scope.markups.intro ) {
			if ( triggered_by == 'previous' ) {
				$scope.session.current_state = 'actual questions';
				if ( $scope.session.section > 0 ) {

				}
			} else {
				exitIntroduction();
			}
		}

		if ( $scope.sections[$scope.session.section].test_instructions_end ) {
			$scope.markups.end = $sce.trustAsHtml($window.marked($scope.sections[$scope.session.section].test_instructions_end));
		}
	}

	var introNextSection = function() {
		$scope.session.current_state = 'introduction';
		$scope.session.section++;

		setToIndexPage();

		setInstructions('introNextSection');
	}

	var leftPad = function( str_to_pad, pad_with, pad_size ) {
		while ( pad_size - str_to_pad.toString().length > 0 ) {
			str_to_pad = [pad_with,str_to_pad].join('');
		}
		return str_to_pad;
	}

	var parseQuestions = function( s ) {
		s.questions = s.questions.map(function(question){
			question.question_no = parseInt(question.question_no);
			question.page_no = parseInt(question.page_no);

			question.user_answers = [];

			angular.forEach(question.user_answers, function( a ) {
				if ($scope.helpers.isShortTextQuestionMultiple(question))
				{
					if ( typeof(question.question_code_id) != 'undefined' )
					{
						if ( typeof(s.question_code_groups) == 'undefined' )
						{
							s.question_code_groups = {};
							s.question_code_groups[question.question_code_id] = {
								keys: []
							}
						}
						s.question_code_groups[question.question_code_id].keys.push(a);
					}
				}
			});
		
			// To avoid creating another similar loop just to look for
			// the last page to show initially, we do the checking here.
			/*
			if ( $scope.order_candidate_test.most_recent_section_id == s.id )
			{
				$scope.session.section = s.sequence_no - 1; // Zero based index needed
				if ( $scope.order_candidate_test.most_recent_page_no == question.page_no || question.layout_id == 13 ) {
					s.page = question.page_no;
					$scope.session.current_state = 'actual questions';
					$scope.session.next = 'Next';
					$scope.session.ticking = 'taking actual';
				} else if ( $scope.order_candidate_test.most_recent_page_no == 0 ) {
					// Introduction to section
					$scope.session.current_state = 'introduction';
					$scope.session.ticking = 'taking actual';
				}
				$scope.session.reversible =  s.sequence_no > 1;
			}
*/
			
			if ( $scope.helpers.isShortTextQuestionMultiple(question) ) {
				
			}
			
			if ( s.max_page < question.page_no ) {
				s.max_page = question.page_no;
			}

			return question;
		});

		return s;
	}

	var parseSections = function( sections ) {
		return sections.map(function(s) {
			s.sequence_no = parseInt(s.sequence_no);
			s.page = 0;
			s.max_page = 1;
			s = parseQuestions(s);
			return s;
		});
	}

	var recalculateProgress = function() {
		console.log('all_questions');
		console.log($scope.session.all_questions);
	
		var completed = 0;
		angular.forEach($scope.session.all_questions, function(q){
			if ( typeof(q.user_answers) != 'undefined' )
			{
				var fully_answered = q.user_answers.length;
				angular.forEach(q.user_answers, function(a) {
					fully_answered = fully_answered && a.answer_text;
				});
				if ( fully_answered ) {
					completed++;
				}	
			}
		});

		$scope.session.progress = Math.ceil(completed / $scope.session.all_questions.length * 100) + '%';
		console.log('recalculate:' + $scope.session.progress);
	}

	var setActualTimeLimit = function() {

		$scope.session.time_limit_actual = {
			minutes: 0,
			seconds: 0
		}
		if ( $scope.order_candidate_test.test.time_limit_actual > 0 ) {
			$scope.session.time_limit_actual.seconds = leftPad($scope.order_candidate_test.test.time_limit_actual % 60, '0', 2);

			$scope.session.time_limit_actual.minutes = ($scope.order_candidate_test.test.time_limit_actual - $scope.session.time_limit_actual.seconds) / 60;

			if ( $scope.session.time_limit_actual.minutes < 0 ) {
				$scope.session.time_limit_actual.minutes = 0;
			} else {
				$scope.session.time_limit_actual.minutes = leftPad($scope.session.time_limit_actual.minutes, '0', 2);
			}
		}

		if ($scope.session.current_state == 'actual questions') {
			$scope.session.remaining = $scope.session.time_limit_actual;
		}
	}

	var getActualUtcTime = function() {
		act_utc = new Date().toISOString().split('T').join(' ').split('.')[0];
		var ymd = act_utc.split(' ')[0];
		ymd = ymd.split('-');

		var his = act_utc.split(' ')[1];
		his = his.split(':');

		act_utc = new Date(ymd[0],ymd[1]-1,ymd[2],his[0],his[1],his[2]);

		return act_utc;
	}

	var startDurationTicker = function() {
		start_utc = getActualUtcTime();
	};

	var stopDurationTicker = function() {
		now_utc = getActualUtcTime();
		$scope.session.data.total_duration = (now_utc.getTime() - start_utc.getTime())/1000;
	};
	var setToLastSectionPage = function() {
		$scope.session.data.page_no = $scope.sections[$scope.session.section].page;
	}
	var setToNextPage = function() {
		$scope.sections[$scope.session.section].page++;
		$scope.session.data.page_no = $scope.sections[$scope.session.section].page;
		$scope.session.data.user_answers = [];
	}
	var setToPreviousPage = function() {
		$scope.sections[$scope.session.section].page--;
		$scope.session.data.page_no = $scope.sections[$scope.session.section].page;
		$scope.session.next = 'Next';
	};
	var setToIndexPage = function() {
		// Intro page
		$scope.session.current_state = 'introduction';
		$scope.sections[$scope.session.section].page = 0;
	}
	var setToFirstPage = function() {
		$scope.sections[$scope.session.section].page = 1;
		$scope.session.data.page_no = 1;
	};
	var setToClosingPage = function() {

	}

	$scope.session = {
		current_state: 'introduction',
		previous: 'Previous',
		progress: '0%',
		page: 0,
		reversible: false,
		pause: false,
		incomplete: false,
		redirect_on_complete: '',
		data: {},
		messages: []
	};

	$scope.helpers = nsTest.helpers;
	$scope.action = 'navigating';
	$scope.sections = [];

	$interval(function(){
		if ($scope.session.current_state == 'sample questions' && $scope.order_candidate_test.test.time_limit_sample) {
			$scope.order_candidate_test.test.time_limit_sample--;
		} else if ($scope.session.current_state == 'actual questions' && $scope.order_candidate_test.test.time_limit_actual) {
			$scope.order_candidate_test.test.time_limit_actual--;
			setActualTimeLimit();
		}
	}, 1000)

	
	/* $scope functions below (arranged alphabetically) */
	$scope.selected_answers = [];

	$scope.alreadyAnswered = function(q) {
		var answered = (typeof(q.user_answers) != 'undefined') ? q.user_answers.length : 0;
		angular.forEach(q.user_answers, function(o) {
			if ( !o.answer_id && !o.answer_text ) {
				answered = false;
			}
		});
		return answered;
	}

	$scope.answerMultipleChoiceQuestion = function( q, mcqa, a, idx ) {
		var i = parseInt(idx);

		if ( typeof(q.question_code_id) != 'undefined' )
		{
			if ( typeof($scope.sections[$scope.session.section].question_code_groups) != 'undefined' )
			{
				if ( typeof($scope.sections[$scope.session.section].question_code_groups[q.question_code_id]) != 'undefined' )
				{
					var choices = $scope.sections[$scope.session.section].question_code_groups[q.question_code_id].keys;
					
					if ( q.user_answers.length > choices.length ) {
						q.user_answers.splice(0, q.user_answers.length - choices.length);
					}
					for (var j = 0; j < choices.length; j++){
						var tmp = {
							answer_id: null,
							answer_text: null
						}
						if ( typeof(q.user_answers[j]) != 'undefined' )
						{
							tmp.answer_id = q.user_answers[j].answer_id;
							tmp.answer_text = q.user_answers[j].answer_text;
						} else {
							q.user_answers.push(tmp);
						}
					};
				}
			}
		}
		q.user_answers[i].answer_id = a.id;
		q.user_answers[i].answer_text = a.answer_text;
			
		if ( typeof(q.user_answers) == 'undefined' )
		{
			q.user_answers = [{
				test_question_id: q.id,
				answers: []
			}];
		}

		// q.user_answers[0].answers = q.answer_data;
		$scope.session.data.user_answers = [{
			test_question_id: q.id,
			answers: q.user_answers
		}]
		$scope.action = 'answered';
		$scope.session.data.section_id = $scope.sections[$scope.session.section].id;

		$scope.session.incomplete = false;
		
		for(var i= 0; i < $scope.session.data.user_answers[0].answers.length; i++) {
			if ($scope.session.data.user_answers[0].answers[i].answer_id == null) {
				$scope.session.incomplete = true;
				break;
			}
		};
	}

	$scope.answerQuestion = function( q, a, q_index ) {
		if ( $scope.session.current_state == 'sample questions' ) {
			$scope.sample_question_most_recent_answer = a.id;
			return;
		}

		if (  q.user_answers.length > 0 && q.user_answers[0].answer_text != a.answer_text ) {
			$scope.action = 'answered';
		}

		$scope.validatePageAnswers(q, a, $scope.sections[$scope.session.section]);
		return;
	}

	$scope.getNumberOfQuestions = function() {
		var total_questions = 0;
		angular.forEach($scope.session.all_questions, function(q){
			if ( q.question_no > 0 ) total_questions++;
		})
		return total_questions;
	}

	$scope.isOfCurrentPage = function( a, b ) {
		return a == b;
	}

	$scope.previous = function() {
		
		window.scrollTo(0, 0);
		stopDurationTicker();
		$scope.sample_question_most_recent_answer = '';
		$scope.session.next = 'Next';
		$scope.session.incomplete = false;
		if ($scope.session.current_state == 'completed') {
			$scope.session.current_state = 'actual questions';
		}
		else if ( $scope.session.current_state == 'introduction' || section.isFirstPageOfNoIntro() ) {
			$scope.session.current_state = 'actual questions';
			if ( $scope.session.section > 0 ) {
				$scope.session.section--;
				setToLastSectionPage();
			}
		}
		else {
			$scope.session.next = 'Next';
			if ( $scope.sections[$scope.session.section].page == 1 && $scope.helpers.sectionHasStartInstruction($scope.sections[$scope.session.section]) ) {
				setToIndexPage();
				enablePreviousPageButton();
			}
			else if ( $scope.sections[$scope.session.section].page > 1 ) {
				setToPreviousPage();
			} else if ( $scope.session.current_state == 'sample questions' ) {
				setToIndexPage();
			} else if ( $scope.session.section > 0 ) {
				setToIndexPage();
				$scope.session.previous = 'Previous';
			}
		}
		setInstructions('previous');

		if ($scope.session.current_state != 'sample questions') {
			checkIncomplete();
			recalculateProgress();
			$scope.session.questions = $scope.sections[$scope.session.section].questions;
			if ( $scope.action == 'answered' ) {
				stopDurationTicker();
				startDurationTicker();
				enablePreviousPageButton();
				$scope.action = 'navigating';				
			}
		}
	}
	var answerFailed = function(error) {
		if ( typeof(error.data) != 'undefined' ) {
			if ( typeof(error.data.message) != 'undefined' )
			{
				$scope.session.messages = error.data.message;
			}
		}
	}

	$scope.proceed = function() {
		window.scrollTo(0, 0);
		stopDurationTicker();
		$scope.session.messages = false;
		next_page = section.getNextPage();
		if ( !next_page && $scope.session.current_state == 'sample questions' ) {
			gatherActualQuestions();
			next_page = 1;
			$scope.sections[$scope.session.section].page = 0;
			$scope.session.data.page_no = 0;
		}
		$scope.sample_question_most_recent_answer = '';

		if ( !next_page
			&& $scope.sections.length > $scope.session.section+1
			&& $scope.helpers.isMCQMatrixQuestionWithoutIntro($scope.sections[$scope.session.section+1].questions[0])
			&& $scope.action == 'answered'
		) {
			
				startDurationTicker();
				/*	Next section's first page has no intro, 
					set to intro so that it is skipped on current_state checking next */
				if ($scope.session.current_state != 'sample questions') {
					$scope.session.section++;
				}
				$scope.sections[$scope.session.section].page = 0;
				$scope.session.current_state = 'actual questions';
				setToFirstPage();
				$scope.session.current_state = 'actual questions';
				$scope.session.ticking = 'taking actual';
				$scope.session.remaining = $scope.session.time_limit_actual;
				$scope.session.questions = $scope.sections[$scope.session.section].questions;
				setInstructions('proceed');
				checkIncomplete();
				recalculateProgress();									
				$scope.action = 'navigating';

		}
		else if ( $scope.session.current_state == 'introduction' )
		{
			exitIntroduction();
			checkIncomplete();
		} else if ( $scope.session.current_state == 'completed' ) {
			closeTest();
		} else if ( $scope.action == 'navigating' ) {
			/* No changes in answers */
			if (next_page) {
				setToNextPage();
			} else {
				if ( typeof($scope.sections[$scope.session.section+1]) != 'undefined' ) {
					// There is a next section
					introNextSection();
				} else {
					// No other sections, test is complete
					enterEndOfTest();
				}
			}
		} else {
			$scope.action = 'navigating';
			if ( next_page ) {
				setToNextPage();
				startDurationTicker();
				var next_page_questions = section.getPageQuestions( next_page );
				// Next page has no questions and next section does not exist
				if (next_page_questions.length == 0) {
					if ( $scope.session.current_state == 'sample questions' )
					{
						$scope.session.current_state = 'actual questions';
						$scope.sections[$scope.session.section].page = 1;
					} else {
						$scope.session.section++;
					}
				}
				checkIncomplete();
				recalculateProgress();
			} else {
				if ( typeof($scope.sections[$scope.session.section+1]) != 'undefined' ) {
					// There is a next section
					introNextSection();
				} else {
					// No other sections, test is complete
					enterEndOfTest();
				}
			}
			
		}
		enablePreviousPageButton();
		checkIncomplete();
	}

	$scope.isMulipleQuestion = function( q ) {
		var question_type_id = $scope.sections[$scope.session.section].question_type_id;
		if ( q.question_type_id ) question_type_id = q.question_type_id;

		return question_type_id == question_type.multiple;
	}

	$scope.markdownToHTML = function ( markdown ) {
		return $sce.trustAsHtml($window.marked(markdown));
	}

	$scope.removeAnswer = function(question, $index) {
		$scope.action = 'answered';
		$scope.session.data.section_id = $scope.sections[$scope.session.section].id;
		question.user_answers.splice($index, 1);
		$scope.sections[$scope.session.section].question_code_groups[question.question_code_id].keys.splice($index, 1);
		$scope.session.data.user_answers = [{
			test_question_id: question.id,
			answers: question.user_answers
		}];
		checkIncomplete();
	}

	$scope.submitForMultipleAnswerQuestion = function(question) {
		if (!$scope.session.answer) return false;

		if ( typeof(question.user_answers) == 'undefined' ) {
			question.user_answers = [];
			// question.user_answers = [{
			// 	test_question_id: question.id,
			// 	answer_text: $scope.session.answer,
			// 	answer_id: null
			// }];
		} else if ( question.user_answers.filter(function( obj ) {
				  return obj.answer_text == $scope.session.answer;
				}).length > 0) {
			$scope.session.answer = '';
			return false;
		}
		// Max 10 stressors
		if ( question.user_answers.length >= 10 ) return false;

		if ( typeof(question.question_code_id) != 'undefined' )
		{
			if ( typeof($scope.sections[$scope.session.section].question_code_groups) == 'undefined' )
			{
				$scope.sections[$scope.session.section].question_code_groups = {};
				$scope.sections[$scope.session.section].question_code_groups[question.question_code_id] = {
					keys: []
				};
			}

			$scope.sections[$scope.session.section].question_code_groups[question.question_code_id].keys.push({
				test_question_id: question.id,
				answer_id: null,
				answer_text: $scope.session.answer
			});
		}
		question.user_answers.push({answer_id: null, answer_text: $scope.session.answer});
		$scope.session.data.section_id = $scope.sections[$scope.session.section].id;
		$scope.session.data.user_answers = [{
			test_question_id: question.id,
			answers: question.user_answers
		}];
		$scope.action = 'answered';
		$scope.session.answer = '';
		$scope.session.incomplete = false;
	}

	$scope.toNum = function( i ) {
		return parseInt(i)
	}

	/* Used to rank stressors */
	$scope.updateQuestionAnswers = function(q, i, v) {

		if (typeof(q.user_answers) == 'undefined') {
			q.user_answers = [];
			angular.forEach($scope.session.global.answers, function(){
				q.user_answers.push(null);
			});
			$scope.session.answer_value_type = 'rank';
		} else if (q.user_answers.length != $scope.session.global.answers.length) {
			q.user_answers = new Array($scope.session.global.answers.length);
		}

		$scope.action = 'answered';

		q.user_answers[i] = v;

		$scope.session.incomplete = q.user_answers.indexOf(null) >= 0;

		$scope.session.data.answer_text = q.user_answers.join(',');

		$scope.session.data.user_answers = q.user_answers;
	}

	$scope.validatePageAnswers = function(question, answer, section) {
		$scope.session.incomplete = false;
		var page_questions = $filter('filter')(section.questions, { page_no: section.page }, true);
		$scope.session.data.section_id = $scope.sections[$scope.session.section].id;

		page_questions.map(function(q){
			var answer_object = {
				test_question_id: q.id,
				answers: [{
					answer_id: answer.id ? answer.id : null,
					answer_text: answer.answer_text ? answer.answer_text : null
				}]
			}
			$scope.session.incomplete = $scope.session.incomplete || answer_object.answers[0].answer_text == null;
			$scope.action = $scope.session.incomplete ? 'navigating' : 'answered';
		});
		
		$scope.session.data.user_answers = page_questions.map(function(q){
			var question_answers = {
				test_question_id: q.id,
				answers: []
			};
			angular.forEach(q.user_answers, function(d){
				if (d.answer_id || d.answer_text) {
					question_answers.answers.push({
						answer_id: d.answer_id ? d.answer_id : null,
						answer_text: d.answer_text ? d.answer_text : null
					});
				}
			});
			var answer_options = q.answers;
			// Source of answers should be answer_group if it is of matrix
			if ( $scope.helpers.isMCQMatrixQuestion( q ) ) {
				answer_options = q.answer_group.details;
			}
			angular.forEach(answer_options, function(d){
				if ( d.id == answer.id && (d.id || d.answer_text) && q.id == question.id )
				{
					if (!parseInt(q.has_multiple_answers)) {
						question_answers.answers = [{
							answer_id: d.id ? d.id : null,
							answer_text: d.answer_text ? d.answer_text : null
						}];
					} else {
						question_answers.answers.push({
							answer_id: d.id ? d.id : null,
							answer_text: d.answer_text ? d.answer_text : null
						});
					}
				}
			});
			if ( question.id == q.id ) {
				question.user_answers = question_answers.answers;
				q.user_answers = question_answers.answers;
			}
			return question_answers;
		});

		checkIncomplete();
	}

	/* start */
	$rootScope.$on('testReady', function( e, that_session ) {
		LearningStyleService.getTest().success(function(response) {
			
			$scope.data_loaded = true;
			
			$scope.session.section = 0;
			$scope.session.next = 'Next';
			//TODO:: $scope.session.redirect_on_complete = that_session.post_test_url;
			$scope.order_candidate_test = response.data;
			$scope.sections = parseSections($scope.order_candidate_test.test.sections);

			$scope.session.all_questions = [];
			for (var i = 0; i < $scope.sections.length; i++) {
				if ( $scope.session.section > 0 && i < $scope.session.section ) {
					$scope.sections[i].page = $scope.sections[i].max_page;
				}

				$scope.session.all_questions = $scope.session.all_questions.concat($scope.sections[i].questions);
			}
			$filter('orderBy', $scope.session.all_questions, 'question_no' );
			
			$scope.session.data = {
				test_id: $scope.order_candidate_test.test_id,
				page_no: $scope.order_candidate_test.most_recent_page_no
			}
			if ( $scope.order_candidate_test.start_time_at ) {
				$scope.session.data.start_time_at = start_utc = new Date($scope.order_candidate_test.start_time_at);

			}

			$scope.markups = {
				intro: '',
				end: $sce.trustAsHtml($window.marked($scope.order_candidate_test.test.test_instructions_end)),
				page: ''
			}

			
			if ( typeof($scope.sections[$scope.session.section]) != 'undefined' ) {
				setInstructions('testReady');
			} else {
				// Test already completed so let's rewind the section minus 1
				// because we are using it for zero based index.
				$scope.session.section = $scope.session.section-1;
				$scope.session.questions = $scope.sections[$scope.session.section].questions;
				setInstructions('testReady');
				enterEndOfTest();
			}

			if ( $scope.session.current_state == 'actual questions' )
			{
				$scope.session.remaining = $scope.session.time_limit_actual;
				$scope.session.questions = $scope.sections[$scope.session.section].questions;
				
				var end_of_section = section.getNextPage() == 0;
				enablePreviousPageButton();
				
				setActualTimeLimit();
				startDurationTicker();
				checkIncomplete();
			}
			recalculateProgress();
		});
	});
}	