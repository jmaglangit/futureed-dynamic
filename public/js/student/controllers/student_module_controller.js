angular.module('futureed.controllers')
	.controller('StudentModuleController', StudentModuleController);

StudentModuleController.$inject = ['$scope', '$window', '$interval', '$filter', 'apiService', 'StudentModuleService', 'SearchService', 'TableService'];

function StudentModuleController($scope, $window, $interval, $filter, apiService, StudentModuleService, SearchService, TableService) {
	var self = this;

	SearchService(self);
	self.searchDefaults();

	TableService(self);
	self.tableDefaults();

	self.giveTip = function() {
		$scope.$broadcast('toggle-tips');
	}

	self.askHelp = function() {
		$scope.$broadcast('toggle-help');
	}

	/**
	* Functions related to module
	*/
	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		$scope.from_module = Constants.FALSE;

		self.active_questions = Constants.FALSE;
		self.active_contents = Constants.FALSE;
		self.result = Constants.FALSE;
		self.date_start = new Date();
		self.load_module_content = Constants.FALSE;
		self.bool_change_class = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_QUESTIONS 	:
				self.active_questions = Constants.TRUE;
				break;

			case Constants.ACTIVE_CONTENTS 	:
				self.active_contents = Constants.TRUE;
				break;

			default 		:
				break;
		}
	}

	/**
	* Updates Student Module
	*/
	var updateModuleStudent = function(data, successCallback) {
		//$scope.ui_block();
		StudentModuleService.updateModuleStudent(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					var student_update = response.data;

					self.points_to_finish = student_update.module.points_to_finish;
					self.current_points = student_update.running_points;

					if(successCallback) {
						successCallback(response);
					}
				}
			}

			//$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	var createModuleStudent = function(data, successCallback) {
		$scope.ui_block();
		StudentModuleService.createModuleStudent(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					if(successCallback) {
						successCallback(response);
					}
				}
			}

			//$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	var getClassrooms = function(successCallback) {
		StudentModuleService.listClass($scope.user.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					if(successCallback) {
						successCallback(response);
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.launchModule = function(module_id) {
		// get module details
		self.getModuleDetail(module_id, function(response) {
			if(response.data)
			{
				self.record = response.data;
				self.student_module_subject_name = self.record.subject.name;

				var class_id = Constants.FALSE;
				var student_modules = self.record.student_module_valid;
				var student_id = parseInt($scope.user.id);
				var student_module = Constants.FALSE;

				// Check if student has existing data
				for (var key = 0; key < student_modules.length; key++) {
					if(angular.equals(parseInt(student_modules[key].student_id), student_id)) {
						student_module = {
							id								: student_modules[key].id
							, class_id						: student_modules[key].class_id
							, last_answered_question_id		: student_modules[key].last_answered_question_id
							, question_counter				: student_modules[key].question_counter
							, module_status					: student_modules[key].module_status
						}
						break;
					}
				}
				// if student module data exists; continue.
				if(student_module) {
					self.record.student_module = student_module;
					loadModuleView();
				} else {
					// else; get class list to get the class id for this module
					getClassrooms(function(response) {
						var data = response.data.records;
						var subject_id = self.record.subject_id;

						// look for same subject ID, checking is by subject ID since each class has unique subject
						for (var key = 0; key < data.length; key++) {
							if(angular.equals(parseInt(data[key].classroom.subject_id), parseInt(subject_id))) {
								class_id = data[key].class_id;
								break;
							}
						};

						// create student_module data
						var data = {};
							data.class_id = class_id;
							data.student_id = $scope.user.id;
							data.module_id = self.record.id;
							data.subject_id = subject_id;

						createModuleStudent(data, function(response) {
							if(response.data) {
								var data = response.data;

								self.record.student_module = {
									id								: data.id
									, class_id						: data.class_id
									, last_answered_question_id		: data.last_answered_question_id
									, question_counter				: data.question_counter
									, module_status					: data.module_status
								}

								loadModuleView();
							} else {
								self.errors = $scope.internalError();
							}
						});
					});
				}
			} else {
				self.errors = $scope.internalError();
			}
		});

	}

	var loadModuleView = function() {
			self.getTeachingContents(self.record.id);

	}

	var getAvatarPose = function(avatar_id) {
		StudentModuleService.getAvatarPose(avatar_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.avatar_pose = response.data;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	var listAvatarQuotes = function(avatar_id) {
		StudentModuleService.listAvatarQuotes(avatar_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.avatar_quotes = response.data;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	var listQuestions = function(successCallback) {
		self.errors = Constants.FALSE;

		self.search.module_id = self.record.id;

		$scope.ui_block();
		StudentModuleService.listQuestions(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.questions = response.data.records;
					if(successCallback) {
						successCallback(response);
					}
				}
			}

			//$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.exitModule = function(redirect_to) {

		if(self.errors){
			$window.location.href = redirect_to
		}else {
			var data = {};
			data.module_id = self.record.student_module.id;

			if(self.active_contents && self.contents) {
				data.last_viewed_content_id = self.contents.content_id;
			}

			if(self.active_questions) {
				data.last_answered_question_id = parseInt(self.questions.id);
			}

			updateModuleStudent(data, function() {
				$window.location.href = redirect_to + "/" + self.record.student_module.class_id;
			});
			$scope.ui_unblock();
		}

	}

	self.viewRewards = function(){

		self.module_message.show = Constants.FALSE;

		$scope.displayRewardsModal(Constants.MODULE);

	}

	self.paginateContent = function() {
		// get next / prev content details
		// update student_module

		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		var page = self.table.page;

		self.table.page = (page < Constants.DEFAULT_PAGE) ? Constants.DEFAULT_PAGE : page;
		self.table.offset = (page - 1) * self.table.size;
		self.getTeachingContents(self.search.module_id);

	}

	self.startQuestions = function(object) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		listQuestions(function(response) {
			self.module_message = {};

			if(!self.questions.length) {
				self.module_message.no_questions = Constants.TRUE;
			} else {
				self.module_message.points_earned = self.record.points_earned;
				self.module_message.badge_to_earn = self.record.badge_to_earn;
				self.module_message.description = self.record.description;
				self.module_message.skip_module = Constants.TRUE;
			}

			self.module_message.name = self.record.name;

			//Check of module has been loaded
			if(!self.load_module_content){
				self.module_message.show = Constants.TRUE;
				$("#message_modal").modal({
					backdrop: 'static',
					keyboard: Constants.FALSE,
					show    : Constants.TRUE
				});
			}

			$scope.ui_unblock();

		});
	}

	self.skipModule = function()
	{
		if(self.result != Constants.FALSE && self.has_coding_exercise)
		{
			self.record.student_module.last_answered_question_id = self.result.next_question;
		}

		if(self.questions[0].question_type == Constants.CODING)
		{
			self.setActive(Constants.ACTIVE_QUESTIONS);
		}
		else
		{
			self.setActive(Constants.ACTIVE_CONTENTS);
		}

		getAvatarPose($scope.user.avatar_id);
		listAvatarQuotes($scope.user.avatar_id);

		if(parseInt(self.record.student_module.last_answered_question_id)) {
			angular.forEach(self.questions, function(value, key) {

				if(value.question_type == Constants.CODING) {
					self.has_coding_exercise = Constants.TRUE;
				}

				if(angular.equals(parseInt(self.record.student_module.last_answered_question_id), parseInt(value.id))) {
					self.current_question = self.questions[key];
					if(self.record.content.length == 0 && self.current_question.question_type === Constants.CODING)
					{
						var data = {};
						data.q_id = self.current_question.id;
						data.c_id = self.record.student_module.class_id;

						self.getSnapQuestionDetails(data, function(resp)
						{
							var data = resp.data;
							var curr_exercise = data.snap;

							if(data.all_exercises_completed)
							{
								self.continueToNextSnapExercise();
							}
							else if(curr_exercise)
							{
								if(curr_exercise.is_exercise_completed == Constants.TRUE)
								{
									snap.isSnapExerciseCompleted = Constants.TRUE;
									snap.showModal();
								}
								snap.finish_count = data.completed_exercises_count;
							}
						});
					}
				}
			});
		}
		else {
			self.current_question = self.questions[0];
		}

		if(angular.equals(self.current_question.question_type, Constants.ORDERING)) {
			self.answerTextOrderGenerator();
		}

		if(angular.equals(self.current_question.question_type, Constants.FILLINBLANK)) {
			var input_fields = [];
			var field_count = parseInt(self.current_question.answer_text_field);

			for(var index = 0; index < field_count; index++) {
				input_fields.push(index);
			}

			self.current_question.answer_text_field_count = input_fields;
		}

		self.question_counter = (self.record.student_module.question_counter) ? parseInt(self.record.student_module.question_counter) + 1 : 1;

		var data = {};
			data.module_id = self.record.student_module.id;
			data.last_answered_question_id = parseInt(self.current_question.id);

		updateModuleStudent(data, function(resp) {
			if(resp.data)
			{
				self.record.student_module.last_answered_question_id = resp.data.last_answered_question_id;
			}
		});
		$scope.ui_unblock();
	}

	//ordering parse strings into object
	self.answerTextOrderGenerator = function(){
		self.order_items = self.current_question.question_order_text.split(",");

		var answer_text = [];
		angular.forEach(self.order_items,function(v,i){
			var object = {
				value : v,
				key : i
			};
			answer_text.push(object);
		});
		self.current_question.answer_text = answer_text;
	}

	self.skipSnapQuestion = function() {
		var found = false;

		snap.isSnapExerciseCompleted = Constants.FALSE;
		snap.correct = Constants.FALSE;

		self.setActive(Constants.ACTIVE_QUESTIONS);

		getAvatarPose($scope.user.avatar_id);
		listAvatarQuotes($scope.user.avatar_id);

		if(parseInt(self.record.student_module.last_answered_question_id)) {
			angular.forEach(self.questions, function(value, key) {
				if(value.id > self.current_question.id && value.question_type === Constants.CODING && !found) {
					self.current_question = self.questions[key];
					found = true;
				}
			});
			if(!found) {
				self.current_question = self.questions[0];
			}
		}

		var data = {};
			data.module_id = self.record.student_module.id;
			data.last_answered_question_id = parseInt(self.current_question.id);

		updateModuleStudent(data, function(resp){
			self.getModuleDetail(self.record.id, function(response) {
				if(response.data) {
					self.record = response.data;
					self.student_module_subject_name = self.record.subject.name;

					var student_modules = self.record.student_module_valid;
					var student_id = parseInt($scope.user.id);
					var student_module = Constants.FALSE;

					// Check if student has existing data
					for (var key = 0; key < student_modules.length; key++) {
						if(angular.equals(parseInt(student_modules[key].student_id), student_id)) {
							student_module = {
								id                          : student_modules[key].id,
								class_id                    : student_modules[key].class_id,
								last_answered_question_id   : student_modules[key].last_answered_question_id,
								question_counter            : student_modules[key].question_counter,
								module_status               : student_modules[key].module_status
							}
							break;
						}
					}

					// if student module data exists; continue.
					if(student_module) {
						self.record.student_module = student_module;
					}

					var data = {};
					data.q_id = self.current_question.id;
					data.c_id = self.record.student_module.class_id;

					self.getSnapQuestionDetails(data, function(resp)
					{
						var data = resp.data;
						var curr_exercise = data.snap;

						if(data.all_exercises_completed)
						{
							self.continueToNextSnapExercise();
						}
						else if(curr_exercise)
						{
							if(curr_exercise.is_exercise_completed == Constants.TRUE)
							{
								snap.isSnapExerciseCompleted = Constants.TRUE;
								snap.showModal();
							}
						}

						self.set_IDE();
					});
				} else {
					self.errors = $scope.internalError();
				}
			});
		});
	}

	self.getSnapQuestionDetails = function(data, callBack) {
		StudentModuleService.getSnapQuestionDetails(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					if(callBack) {
						callBack(response);
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getModuleDetail = function(id, successCallback) {
		$scope.ui_block();
		StudentModuleService.getModuleDetail(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					if(successCallback) {
						successCallback(response);
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getTeachingContents = function(id) {
		self.search.module_id = id;
		self.table.size = 1;
		self.content_index = Constants.FALSE;

		$scope.ui_block();
		StudentModuleService.getTeachingContents(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					self.contents = response.data.records;//[0]
					self.content = self.contents[self.content_index];
					self.updatePageCount(response.data);

					if(self.contents) {
						var data = {};
							data.module_id = self.record.student_module.id;

							if(self.active_contents) {
								data.last_viewed_content_id = self.contents.id;
							}

						updateModuleStudent(data);
						$scope.ui_unblock();
					}
					self.startQuestions();
				}
			}

			//$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

    self.showContent = function(content) {
        self.content = content;
    }

    self.nextPageContent = function() {
        self.content_index++;
        self.content = self.contents[self.content_index];

        if (typeof self.content == Constants.UNDEFINED) {
            self.content_index = 0;
            self.nextPage();
    	}
    }

    self.prevPageContent = function() {
        self.content_index--;
        self.content = self.contents[self.content_index];

        if (typeof self.content == Constants.UNDEFINED) {
            self.content_index = self.contents.length - 1;
            self.previousPage();
        }
    }

	self.getModuleStudent = function(module_id, successCallback) {
		$scope.ui_block();
		StudentModuleService.getModuleStudent(module_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(successCallback) {
						successCallback(response);
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.continueToNextSnapExercise = function () {
		self.errors = Constants.FALSE;
		var answer = {};

		answer.student_module_id = self.record.student_module.id;
		answer.module_id = self.record.id;
		answer.seq_no = self.current_question.seq_no;
		answer.question_id = self.current_question.id;
		answer.classroom_id = self.record.student_module.class_id;
		answer.answer_id = self.current_question.answer_id;
		answer.student_id = $scope.user.id;
		answer.date_start = self.snap_exercise_start || new Date();
		answer.date_end = new Date();

		self.current_student_module = {
			module_id : self.record.id,
			question_id : self.current_question.id,
			seq_no	:	self.current_question.seq_no
		};

		answer.answer_text = Constants.TRUE;
		
		StudentModuleService.answerSnapExercise(answer).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					self.result = {};

					if(response.errors[0].error_code == 2056) {
						self.result.failed = Constants.TRUE;
					}
				}
				else if(response.data) {
					if(response.data.all_exercises_completed) {
						snap.finish_count = response.data.completed_exercises_count;
						snap.isSnapModuleCompleted = Constants.TRUE;
						self.checkAnswer();
					}
					else {
						self.skipSnapQuestion();
					}
				}
			}
		});
	}

	self.checkAnswer = function() {
		self.errors = Constants.FALSE;
		var answer = {};
		answer.student_module_id = self.record.student_module.id;
		answer.module_id = Number(self.record.id);
		answer.seq_no = self.current_question.seq_no;
		answer.question_id = Number(self.current_question.id);
		answer.answer_id = Number(self.current_question.answer_id);
		answer.student_id = $scope.user.id;
		answer.date_start = self.date_start;
		answer.date_end = new Date();

		self.current_student_module = {
			module_id : self.record.id,
			question_id : self.current_question.id,
			seq_no	:	self.current_question.seq_no
		};

		//insert logic for dynamic questions
		//TODO set variables into dynamic
		//TODO set self.current_question.question_type
		if(self.record.is_dynamic){
			self.setDynamicModuleAnswer();
			answer.answer_text = self.parseQuestionValues(self.current_question.answer_text);
			answer.is_dynamic = self.record.is_dynamic;
		}

		//form answer text ordering into array of objects.
		switch(self.current_question.question_type){
			case Constants.ORDERING:
				var order_answer = self.current_question.answer_text;

				self.order_answer_text = '';
				angular.forEach(order_answer,function(v,i){
					if(i > Constants.FALSE){
						self.order_answer_text += (',' + v.value);
					}else {
						self.order_answer_text += v.value;
					}
				});
				answer.answer_text = self.order_answer_text;
				break;
			case Constants.FILLINBLANK:

				if(!self.record.is_dynamic){

					var answer_text_array = [];

					angular.forEach(self.current_question.answer_text, function(value, key) {
						answer_text_array.push(value);
					});

					answer.answer_text = answer_text_array.join(",");
				}

				break;
			case Constants.GRAPH:
				var answer_graph_array = [];

				//Get horizontal
				if(self.question_graph_content.orientation == Constants.HORIZONTAL){

					//get table data
					//parse each value for horizontal values.
					var horizontalTable = document.getElementById('horizontalTable');

					answer_graph_array = self.horizontalGraph(horizontalTable);


					//Get Vertical
				}else if(self.question_graph_content.orientation == Constants.VERTICAL){

					//parse each value for vertical values
					var verticalTable = document.getElementById('verticalTable');

					answer_graph_array = self.verticalGraph(verticalTable);
				}

				obj = {"answer" : answer_graph_array};
				answer.answer_text = JSON.stringify(obj);
				break;
			case Constants.QUADRANT:
				quadData = self.quad.getData();
				answer_quad_array = [];

				$.each(quadData[0].data, function(i,item){
					if(i > 0){
						obj = {'x' : quadData[0].data[i][0], 'y' : quadData[0].data[i][1]}
						answer_quad_array.push(obj);
					}
				});

				obj = {"answer" : answer_quad_array};
				answer.answer_text = JSON.stringify(obj);
				break;
			case Constants.CODING:
				answer.answer_text = Constants.TRUE.toString();

				break;
			default:
				answer.answer_text = self.current_question.answer_text;
				break;
		}

		$scope.ui_block();
		StudentModuleService.answerQuestion(answer).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					self.result = {};

					if(response.errors[0].error_code == 2056) {
						self.result.failed = Constants.TRUE;
					}

					$scope.ui_unblock();
				}
				else if(response.data) {
					// show message
					self.result = response.data;
					self.result.failed = Constants.FALSE;

					$scope.correct_counter = self.result.correct_counter;

					if(self.result.snap_module_completed) {
						self.snap_exercise_commpleted = self.result.snap_module_completed;
					}

					if(angular.equals(self.result.module_status, "Completed")) {
						// get points
						var data = $scope.user;
							data.points = parseInt(data.points) + parseInt(self.record.points_earned);

						apiService.updateUserSession(data).success(function(response) {
							$scope.getUserDetails();
						});


						var data = {};
							data.age_group = 1;
							data.module_id = self.record.id;
						getPointsEarned(data, function(response) {
							// save points
							var data = {};
								data.student_id = $scope.user.id;
								data.points_earned = self.record.points_earned;
								data.module_id = self.record.id;
								data.student_module_id = self.record.student_module.id;
								data.class_id = self.record.student_module.class_id;

							saveStudentPoints(data, function(response) {
								var avatar_id = $scope.user.avatar_id;

								// get wiki
								getWiki(avatar_id, function(response) {
									$scope.ui_unblock();

									var avatar_wiki = response.data[0];

									self.result = {};

									self.errors = Constants.FALSE;
									self.success = Constants.FALSE;

									self.module_message = {};
									self.module_message.points_earned = (self.record.no_difficulty)
										? $scope.correct_counter : self.record.points_earned;
									self.module_message.show = Constants.TRUE;
									self.module_message.title = avatar_wiki.title;
									self.module_message.name = self.record.name;

									self.module_message.description_summary = avatar_wiki.description_summary;
									self.module_message.description_full = avatar_wiki.description_full;
									self.module_message.message = self.module_message.description_summary;

									self.module_message.image = avatar_wiki.image; // ok
									self.module_message.source = avatar_wiki.source;
									self.module_message.module_done = Constants.TRUE; // ok

									$("#message_modal").modal({
								        backdrop: 'static',
								        keyboard: Constants.FALSE,
								        show    : Constants.TRUE
								    });
								});
							});
						});
					}
					else if(angular.equals(self.result.module_status, "Failed")) {
						self.result.failed = Constants.TRUE;
						$scope.ui_unblock();
					}
					else {
						$scope.ui_unblock();

						// update student_module
						var data = {};
							data.module_id = self.result.id;
							data.last_answered_question_id = parseInt(self.result.next_question);

						updateModuleStudent(data, function(response)
						{
							if(self.current_question.question_type == Constants.CODING && snap.isSnapModuleCompleted && self.snap_exercise_commpleted)
							{
								self.nextQuestion();
								self.snap_module_completed = Constants.FALSE;
							}
							else
								setAvatarQuote();
						});
					}
                    self.record.student_module.last_answered_question_id = self.result.next_question;
				}
				self.date_start = new Date();
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	//parse horizontal table data.
	self.horizontalGraph = function(data){
		var graph_json = [];

		var y = data.rows.length;
		var header_count = data.rows.length;

		//horizontal headers
		for(h=0; h < header_count ; h++){

			header_data = {
				field : data.rows.item(h).cells.item(0).childNodes.item(1).className.replace("origin ",""),
				image :  data.rows.item(h).cells.item(0).childNodes.item(1).childNodes.item(1).attributes.item(1).nodeValue,
				count : 0,
				count_objects : 0
			};

			graph_json.push(header_data);
		}


		//parse the answers
		for(i=0; i < y ; i++){
			var cells = data.rows.item(i).cells;
			var x = cells.length;

			for(t=1; t < x ; t++){

				if(cells.item(t).firstElementChild !== null){

					if(graph_json[i].field == cells.item(t).firstElementChild.className.replace("origin ","")){
						graph_json[i].count = graph_json[i].count + 1;
						graph_json[i].count_objects = graph_json[i].count_objects + 1;
					}else {
						graph_json[i].count_objects = graph_json[i].count_objects + 1;
					}
				}
			}
		}

		return graph_json;
	}

	//parse vertical table data
	self.verticalGraph = function(data){

		var graph_json = [];
		var y = data.rows.length;

		//vertical headers
		var header_count = data.rows.item(0).cells.length;

		//get the headers
		for(h=0; h < header_count ; h++){
			header_data = {
				field : data.rows.item(0).cells.item(h).className,
				image : data.rows.item(0).cells.item(h).childNodes.item(1).childNodes.item(1).attributes.item(1).nodeValue,
				count : 0,
				count_objects : 0
			};

			graph_json.push(header_data);

		}

		//parse the answers
		for(i=1; i < y; i++){
			var cells = data.rows.item(i).cells;
			var x = cells.length;

			for(t=0; t < x; t++){

				if(cells.item(t).firstElementChild !== null){

					if(graph_json[t].field == cells.item(t).firstElementChild.className.replace("origin ","")){
						graph_json[t].count = graph_json[t].count + 1;
						graph_json[t].count_objects = graph_json[t].count_objects + 1;
					}else {
						graph_json[t].count_objects = graph_json[t].count_objects + 1;
					}
				}
			}
		}

		return graph_json;
	}

	self.viewMoreWikiMessage = function() {
		self.module_message.message = self.module_message.description_full;
		self.module_message.full_message = Constants.TRUE;
	}

	var getPointsEarned = function(data, successCallback) {
		StudentModuleService.getPointsEarned(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(successCallback) {
						successCallback(response);
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	var saveStudentPoints = function(data, successCallback) {
		StudentModuleService.saveStudentPoints(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(successCallback) {
						successCallback(response);
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	var getWiki = function(data, successCallback) {
		StudentModuleService.getWiki(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(successCallback) {
						successCallback(response);
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	var setAvatarQuote = function() {
		if(!((self.result.question_counter) % 5)) {
			// get quote
			var percentage = Math.floor((parseInt(self.result.correct_counter) / parseInt(self.result.question_counter)) * 100);
			var seq_no = Math.floor(parseInt(self.result.question_counter) / 5) % 6;
			var avatar_quote_sequence = (!seq_no) ? 6 : seq_no;

			var avatar_quote = self.avatar_quotes[avatar_quote_sequence];
			var avatar_quote_info = {};

			if(percentage < 20) {
				avatar_quote_info = avatar_quote[0];
			} else if(percentage >= 20 && percentage < 40) {
				avatar_quote_info = avatar_quote[20];
			} else if(percentage >= 40 && percentage < 60) {
				avatar_quote_info = avatar_quote[40];
			} else if(percentage >= 60 && percentage < 80) {
				avatar_quote_info = avatar_quote[60];
			} else if(percentage >= 80 && percentage < 100) {
				avatar_quote_info = avatar_quote[80];
			} else if(percentage >= 100) {
				avatar_quote_info = avatar_quote[100];
			} else {
				self.result.answered = Constants.TRUE;
			}

			// get pose
			var avatar_pose_id = avatar_quote_info.avatar_quote.avatar_pose_id;
			angular.forEach(self.avatar_pose, function(value, key) {
				if(angular.equals(parseInt(value.id), parseInt(avatar_pose_id))) {
					avatar_quote_info.avatar_pose = value;
					return;
				}
			});

			self.avatar_quote_info = avatar_quote_info;
			self.result.quoted = Constants.TRUE;
		} else {
			self.result.answered = Constants.TRUE;
		}

		self.result.points_earned = parseInt(self.result.points_earned);
	}

	self.selectAnswer = function(object) {
		self.current_question.answer_id = object.id;
    }

	self.nextQuestion = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.current_question = {};
		angular.forEach(self.questions, function(value, key) {
			if(angular.equals(parseInt(value.id), parseInt(self.result.next_question))) {
				self.current_question = value;
				self.current_question.answer_text = Constants.EMPTY_STR;
				self.current_question.answer_id = undefined;
				self.answer_explanation = Constants.EMPTY_STR;

				if(angular.equals(self.current_question.question_type, Constants.ORDERING)) {
					self.answerTextOrderGenerator();
				}

				if(angular.equals(self.current_question.question_type, Constants.FILLINBLANK)) {
					var input_fields = [];

					var field_count = parseInt(self.current_question.answer_text_field);

					for(var index = 0; index < field_count; index++) {
						input_fields.push(index);
					}

					self.current_question.answer_text_field_count = input_fields;
				}

				self.question_counter = parseInt(self.result.question_counter) + 1;

				self.result = {};
				return;
			}
		});
	}

	self.updateBackground = function() {
		$("footer").css('background-image', 'none');

		angular.element('body.student').css({
			'background-image' : 'url('+ $scope.user.background +')'
		});
	}

	self.dragControlListeners = {
	    accept: function (sourceItemHandleScope, destSortableScope) {
	    	return true;
	    }
	    , itemMoved: function (event) {

	    }
	    , orderChanged: function(event) {

	    }
	    , containment: '#board'//optional param.
	};

	self.reviewContent = function() {
		if(self.result && self.result.failed) {
			// create student_module
			var data = {};
				data.class_id = self.record.student_module.class_id;
				data.student_id = $scope.user.id;
				data.module_id = self.record.id;
				data.subject_id = self.record.subject_id;

			createModuleStudent(data, function(response) {
				if(response.data) {
					var data = response.data;

					self.record.student_module = {
						id								: data.id
						, class_id						: data.class_id
						, last_answered_question_id		: data.last_answered_question_id
						, question_counter				: data.question_counter
						, module_status					: data.module_status
					}

					loadModuleView();
				} else {
					self.errors = $internalError();
				}
			});
		} else {
			self.current_question = {};
			self.launchModule(self.record.id);
		}
	}

	self.getGraph = function(question_id) {
		$scope.ui_block();
		StudentModuleService.getGraph(question_id).success(function(response) {

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					self.graph_layout = [];

					for(i = 0; i < response.data.dimension; i++){
						self.graph_layout.push(i+1);
					}

					self.question_graph_content = JSON.parse(response.data.question_graph_content);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getQuadrant = function(question_id){
		$scope.ui_block();
		StudentModuleService.getGraph(question_id).success(function(response) {

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else {
					//initialize plot data and options
					data = [[null]];
					options = {
						yaxis: { min: -response.data.dimension, max: response.data.dimension, ticks: response.data.dimension * 2},
						xaxis: { min: -response.data.dimension, max: response.data.dimension, ticks: response.data.dimension * 2},
						grid: {clickable: true},
						points: { show: true, radius: 4, fill: true, fillColor: "#EDC240" }
					};

					//draw plot
					self.quad = $.plot($("#placeholder"), data, options);
					$("#placeholder").bind("plotclick", function (event, pos, item) {

						if(!item){
							newData = self.quad.getData();

							//check for duplicates
							$.each(newData[0].data, function(i,item){
								var arr1 = newData[0].data[i];
								var arr2 = [Math.round(pos.x),Math.round(pos.y)];

								if(newData[0].data[i] != null){
									duplicate_point = self.arraysEqual(arr1,arr2);
									if(duplicate_point){
										return false;
									}
								}else{
									duplicate_point = false;
								}
							});

							if(!duplicate_point){
								newData[0].data.push([Math.round(pos.x),Math.round(pos.y)]);
								self.quad.setData(newData);
								self.quad.setupGrid();
								self.quad.draw();
							}
						}
					});
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.initDrag = function (){
		$('.origin').draggable({
			containment: 'table',
			helper: 'clone',
			cursor: 'move',
			cursorAt: { left:-30 }
		});
	}

	self.initDrop = function (){
		$('.drop').droppable({
			accept: '.origin',
			drop: function(event, ui) {
				var thisClass = $(this).hasClass('disabled');

				if(thisClass){
					ui.draggable.draggable('option','revert',true);
				}else{
					$(this).append($(ui.draggable).clone());
					$(this).droppable('disable');
					ui.draggable.draggable('option','revert','invalid');

					if(angular.equals(self.question_graph_content.orientation, Constants.HORIZONTAL)) {
						$(this).next().removeClass('disabled');
					}else{
						var cellIndex = $(this).index();
						$(this).closest('tr').next().children().eq(cellIndex).removeClass('disabled');
					}
				}
			}
		});
	}

	self.resetGraph = function () {
		if(angular.equals(self.current_question.question_type, Constants.GRAPH)){
			$('.drop').removeClass('ui-droppable-disabled ui-state-disabled').addClass('disabled').empty().droppable('enable');
			$('td.first').removeClass('disabled');
		}else if(angular.equals(self.current_question.question_type, Constants.QUADRANT)){
			data = [[null]];
			self.quad = $.plot($("#placeholder"), data, options);
		}
	}

	//function to compare arrays - used to evaluate quadrant plots
	self.arraysEqual = function(arr1, arr2) {
		if(arr1.length !== arr2.length) {
			return false;
		}

		for(var i = arr1.length; i--;) {
			if(arr1[i] !== arr2[i]) {
				return false;
			}
		}

		return true;
	}

	self.previousPage = function()
	{
		if(self.table.page > 1)
		{
			self.load_module_content = Constants.TRUE;
			self.total_module_items_loaded -= self.table.size;
			self.table.page--;
			self.paginateByPage();
		}
	}

	self.nextPage = function()
	{
		if(self.table.page < self.table.total_items)
		{
			self.load_module_content = Constants.TRUE;
			self.total_module_items_loaded += self.table.size;
			self.table.page++;
			self.paginateByPage();
		}
	}

	self.list = function(){

		self.getTeachingContents(self.record.id);
	}

	self.getAnswerExplanation = function(){

		var data = {
			'module_id' : self.current_student_module.module_id,
			'question_id' : self.current_student_module.question_id,
			'seq_no' : self.current_student_module.seq_no
		};
		self.answer_explanation_fully_loaded = Constants.FALSE;
		StudentModuleService.getAnswerExplanation(data).success(function(response){
			if(response.errors){
				self.errors = $scope.errorHandler(response.errors);
			} else {
				self.answer_explanation = response.data.records;
				self.answer_explanation.count = response.data.records.length;
				self.answer_exp_offset = 0;
				self.answer_explanation_fully_loaded = Constants.TRUE;
			}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});


	}

	/**
	 * SNAP Methods and Variables
	 */

	/** -------------------------- **/

	// Variables
	var world;
	var FutureEd_IDE;
	var target_script;
	var isAnswering;
	var canvas;
	var canvas_parent_div;
	var canvas_offset;
	var x_offset;
	var cur_code;

	// self methods and variables
	self.loading = Constants.TRUE;

	self.set_IDE = function() {

		canvas = document.getElementById('world');
		canvas_parent_div = document.getElementById('snap_container');

		canvas.setAttribute('width', ($('#snap_container').width() - 10).toString());
		canvas.setAttribute('height', ($('#snap_main_div_container').height() - 80).toString());

		self.snap_done_answering = Constants.FALSE;
		$('.btn-code-run').text('Run');

		world = new WorldMorph(canvas, false);

		FutureEd_IDE = new IDE_Morph();
		FutureEd_IDE.openIn(world);

		hideIDE();

		self.retrieveModule(self.current_question.id,
			function(resp)
			{

				FutureEd_IDE.rawOpenProjectString(resp);
				FutureEd_IDE.selectSprite(FutureEd_IDE.children[1].children[0]);//select sprites e.i images in the stage

				FutureEd_IDE.corral.hide();
				FutureEd_IDE.corralBar.hide();

				FutureEd_IDE.children[4].bounds = new Rectangle(0,0,0,0);
				FutureEd_IDE.children[4].hide();
				FutureEd_IDE.children[4].drawNew();

				FutureEd_IDE.children[0].bounds = new Rectangle(0,0,0,0);
				FutureEd_IDE.children[0].hide();

				//Left most pane
				FutureEd_IDE.children[2].bounds =
					new Rectangle(
						0, //origin x
						getActualHeightByPercent(0.009),//origin y
						getActualWidthByPercent(0.18348),//corner x
						getActualHeightByPercent(0.99107)//corner y
					);
				FutureEd_IDE.children[2].children[1].bounds =
					new Rectangle(
						0,
						getActualHeightByPercent(0.96964),
						getActualWidthByPercent(0.17247),
						getActualHeightByPercent(0.99107)
					);
				FutureEd_IDE.children[2].children[1].children[0].bounds =
					new Rectangle(
						getActualWidthByPercent(0.19174),
						getActualHeightByPercent(0.97321),
						getActualWidthByPercent(0.15045),
						getActualHeightByPercent(0.98928)
					);
				FutureEd_IDE.children[2].children[2].bounds = new Rectangle(0,0,0,0);
				FutureEd_IDE.children[2].children[2].hide();
				FutureEd_IDE.children[2].drawNew();

				//Center Pane
				FutureEd_IDE.children[3].bounds =
					new Rectangle(
						getActualWidthByPercent(0.18807),
						getActualHeightByPercent(0.009),
						getActualWidthByPercent(0.55504),
						getActualHeightByPercent(0.99107)
					);

				// Center Pane horizontal slider line
				FutureEd_IDE.children[3].children[1].bounds =
					new Rectangle(
						getActualWidthByPercent(0.18807),
						getActualHeightByPercent(0.96964),
						getActualWidthByPercent(0.54403),
						getActualHeightByPercent(0.99107)
					);
				// Center Pane horizontal slider
				FutureEd_IDE.children[3].children[1].children[0].bounds =
					new Rectangle(
						getActualWidthByPercent(0.19174),
						getActualHeightByPercent(0.97321),
						getActualWidthByPercent(0.50733),
						getActualHeightByPercent(0.98928)
					);

				FutureEd_IDE.children[3].children[2].bounds = new Rectangle(0,0,0,0);
				FutureEd_IDE.children[3].children[2].hide();
				FutureEd_IDE.children[3].drawNew();

				var ref_height = FutureEd_IDE.children[3].bounds.corner.y;
				var scale = Math.abs((ref_height) / FutureEd_IDE.children[1].bounds.corner.y);
				var old_stage_width_x = FutureEd_IDE.children[1].bounds.origin.x;

				// Stage location x-axis
				FutureEd_IDE.children[1].bounds.origin.y = getActualHeightByPercent(0.00901);
				FutureEd_IDE.children[1].bounds.origin.x = getActualWidthByPercent(0.55963);

				var gap = Math.abs(FutureEd_IDE.children[3].bounds.corner.x - FutureEd_IDE.children[1].bounds.origin.x);
				var new_stage_width_x = FutureEd_IDE.children[1].bounds.origin.x;

				// Scale stage to fit
				FutureEd_IDE.children[1].setScale(scale);

				// To be used in stageElemsOffset
				x_offset = ((new_stage_width_x  - old_stage_width_x) + gap) / 2;

				// Remove unused px lengthwise due to stage scaling
				canvas_offset = ($(canvas).width() - FutureEd_IDE.children[1].bounds.corner.x);
				canvas.width -= canvas_offset;

				// offset all elements inside stage
				stageElemsOffset(FutureEd_IDE.children[1]);

				// find target script with name "sprite" to be used in fireGreenFlagEvent()
				findTargetScript();
				FutureEd_IDE.stage.fireGreenFlagEvent();

				self.loading = Constants.FALSE;
				self.snap_exercise_start = new Date();
			}
		);

		loop();
	}

	self.retrieveModule = function(filename, callback) {
		StudentModuleService.getSnapModule(filename).success(
			function(response)
			{
				try
				{
					if(response.data.no_file)
					{
						$('#world_container').hide();
					}
				}
				catch (err)
				{
					$('#world_container').show();
					if(callback)
					{
						callback(response);
					}
				}
				//$scope.ui_unblock();
			}
		).
		error(
			function(response)
			{
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			}
		);
	}

	self.runCode = function() {
		if(!self.snap_done_answering) {
			updateCode();
			$('.btn-code-run').text('Reset');
			FutureEd_IDE.stage.doCustomBroadcastEvent("run_code");
			self.snap_done_answering = !self.snap_done_answering;
		}
		else {
			self.snap_done_answering = !self.snap_done_answering;
			$('.btn-code-run').text('Run');
			FutureEd_IDE.stage.fireGreenFlagEvent();
			self.loading = Constants.TRUE;
			self.set_IDE();
		}
	}

	// other methods
	function hideIDE()
	{
		FutureEd_IDE.corral.hide();
		FutureEd_IDE.corralBar.hide();
		FutureEd_IDE.children[4].bounds = new Rectangle(0,0,0,0);
		FutureEd_IDE.children[4].hide();
		FutureEd_IDE.children[0].bounds = new Rectangle(0,0,0,0);
		FutureEd_IDE.children[0].hide();
		FutureEd_IDE.children[1].hide();
		FutureEd_IDE.children[2].hide();
	}

	function stageElemsOffset(stage) {
		if(stage.children.length)
		{
			for(var i = 0; i < stage.children.length; i++)
			{
				stageElemsOffset(stage.children[i]);
			}
		}
		else
		{
			stage.bounds.origin.x += x_offset;
			stage.bounds.corner.x += x_offset;
		}
	}

	function getActualHeightByPercent(percent) {
		var h = $(canvas).height();
		return Math.ceil(h * percent);
	}

	function getActualWidthByPercent(percent) {
		var w = $(canvas).width();
		return Math.ceil(w * percent);
	}

	function updateCode() {
		target_script.mouseClickLeft(true);
	}

	function loop() {
		requestAnimationFrame(loop);
		world.doOneCycle();
	}

	function findTargetScript() {
		var len = FutureEd_IDE.sprites.contents.length;
		for(var i = 0; i < len; i++)
		{
			if(FutureEd_IDE.sprites.contents[i].name == "Sprite")
			{
				target_script =  FutureEd_IDE.sprites.contents[i].scripts.children[FutureEd_IDE.sprites.contents[i].scripts.children.length-1];
				target_script.isDraggable = false;
				target_script.fixLayout();
			}
		}
	}

	/** -------------------------- **/

	self.click = function(){
		self.bool_change_class = !self.bool_change_class;
	}

	//Dynamic questions
	self.parseQuestionValues = function(question_values){

		return JSON.stringify(question_values);
	}

	self.stepsRepeat = function(iterations){

		return new Array(iterations);

		//if(iterations > Constants.TRUE){
		//	return new Array(iterations);
		//} else {
		//	return Constants.FALSE;
		//}
	}

	self.setDynamicModuleAnswer = function(){
		self.current_question.question_type = self.current_question.question_template.question_type;
	};

}