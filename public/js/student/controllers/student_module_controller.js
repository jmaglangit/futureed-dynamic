angular.module('futureed.controllers')
	.controller('StudentModuleController', StudentModuleController);

StudentModuleController.$inject = ['$scope', '$window', '$interval', '$filter', 'apiService', 'StudentModuleService', 'SearchService', 'TableService'];

function StudentModuleController($scope, $window, $interval, $filter, apiService, StudentModuleService, SearchService, TableService) {
	var self = this;

	self.list = [];

	SearchService(self);
	self.searchDefaults();

	TableService(self);
	self.tableDefaults();

	self.add = {};

	self.setTabActive = function(view) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.current_view = view;
	}

	self.toggleBtn = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.toggle_bottom = !self.toggle_bottom;
		self.setTipActive();
	}

	self.toggleBtnHelp = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.toggle_help_bottom = !self.toggle_help_bottom;
		self.setHelpActive();
	}

	self.giveTip = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.toggle_bottom = !self.toggle_bottom;
		self.setTipActive('add');
	}

	self.askHelp = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.toggle_help_bottom = !self.toggle_help_bottom;
		self.setHelpActive('add');
	}

	self.setHelpActive = function(active, id) {
		self.active_help_list = Constants.FALSE;
		self.active_help_add = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_ADD:
				self.active_help_add = Constants.TRUE;
				break;

			default:
				self.active_help_list = Constants.TRUE;
				break;
		}
	}

	self.addHelp = function() {
		// temprary declare ID's
		self.add.module_id = parseInt(1);
		self.add.subject_id = parseInt(1);
		self.add.link_id = parseInt(1);
		self.add.link_type = 'Question';
		self.add.class_id = $scope.user.class.id;
		self.add.student_id = $scope.user.id;

		$scope.ui_block();
		StudentModuleService.addHelp(self.add).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.success = Constants.FALSE;
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = Constants.TRUE;
					self.errors = Constants.FALSE;
					self.add = {};
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.setCurrentActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_current_list = Constants.FALSE;
		self.active_current_view = Constants.FALSE;

		switch(active){
			case Constants.ACTIVE_VIEW:
				self.active_current_view = Constants.TRUE;
				self.answer = {};
				self.getHelpDetails(id);
				break;
			default:
				self.active_current_list = Constants.TRUE;
				self.currentList();
				break;
		}
	}

	self.currentList = function(flag){
		// setting temporary request id
		self.request = {};
		self.request.student_id = $scope.user.id;
		self.request.module_id = 1;
		self.request.link_type = 'Content';
		self.request.help_request_type = studentModule.OTHERS;
		self.request.question_status = 'Open'
		self.request.link_id = 1;
		self.request.limit = (flag == 1) ? 0:3;

		$scope.ui_block();
		StudentModuleService.list(self.request).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.records = {};
					self.records = response.data.records;

					angular.forEach(self.records, function(value, key) {
						value.created_at = moment(value.created_at).startOf("minute").fromNow();
					});
					
					self.show_btn = (response.data.total >= 4 && flag != 1) ? self.show_btn = Constants.TRUE:self.show_btn = Constants.FALSE;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getHelpDetails = function(id) {
		$scope.ui_block();
		StudentModuleService.getHelpDetails(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.details = {};
					var details = response.data;
					self.details.created_at = moment(details.created_at).startOf("minute").fromNow();
					self.details.name = details.student.first_name + ' ' + details.student.last_name;
					self.details.title = details.title;
					self.details.subject_area_name = (details.subject_area) ? details.subject_area.name:Constants.EMPTY_STR;
					self.details.subject_name = (details.subject) ? details.subject.name:Constants.EMPTY_STR;
					self.details.content = details.content;
					self.details.id = details.id;
					self.details.question_status = details.question_status;
					self.details.stars = new Array(5);
					if(self.details.question_status == Constants.ANSWERED){
						self.hide = Constants.TRUE;
					}
					self.getHelpAnswer(self.details.id);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getHelpAnswer = function(id) {
		self.answer_status = Constants.ACCEPTED;
		StudentModuleService.getHelpAnswer(id, self.answer_status).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.ans_record = response.data.records;
				}
			}
		}).error(function(response){	
			self.errors = $scope.internalError();
		});
	}

	self.submitAnswer = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.answer.student_id = $scope.user.id;
		self.answer.help_request_id = self.details.id;

		$scope.ui_block();
		StudentModuleService.submitAnswer(self.answer).success(function(response){
			if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = studentModule.ADD_ANSWER_SUCCESS;
					self.answer = {};
					self.getHelpAnswer(self.details.id);
				}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.setOwnActive = function(active, id, flag) {
		self.errors = Constants.FALSE;
		if(flag != 1){
			self.success = Constants.FALSE;
		}

		self.active_own_list = Constants.FALSE;
		self.active_own_view = Constants.FALSE;

		switch(active){
			case Constants.ACTIVE_VIEW:
				self.active_own_view = Constants.TRUE;
				self.answer = {};
				self.getHelpDetails(id);
				break;
			default:
				self.active_own_list = Constants.TRUE;
				self.ownList();
				break;
		}
	}

	self.ownList = function(flag) {
		// setting temporary request id
		self.request = {};
		self.request.student_id = $scope.user.id;
		self.request.module_id = 1;
		self.request.link_type = 'Content';
		self.request.help_request_type = studentModule.OWN;
		self.request.question_status = 'Open,Answered'
		self.request.link_id = 1;
		self.request.limit = (flag != 1) ? 0:3;

		$scope.ui_block();
		StudentModuleService.list(self.request).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.own_records = {};
					self.own_records = response.data.records;

					angular.forEach(self.own_records, function(value, key) {
						value.created_at = moment(value.created_at).startOf("minute").fromNow();
					});
					self.show_btn = (response.data.total >= 4 && flag != 1) ? self.show_btn = Constants.TRUE:self.show_btn = Constants.FALSE;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.updateHelp = function(id, flag) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.question_status = (flag == 1) ? studentModule.CANCEL : studentModule.CLOSE;

		$scope.ui_block();
		StudentModuleService.updateHelp(id, self.question_status).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = (flag == 1) ? studentModule.THREAD_DELETED: studentModule.THREAD_CLOSED;
					if(flag == 1) {
						self.setOwnActive('', '', 1)
					}else {
						self.hide = Constants.TRUE;
						self.getHelpDetails(id);
					}
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})

	}

	self.setTipActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_tip_add = Constants.FALSE;
		self.active_tip_list = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_ADD :
				self.active_tip_add = Constants.TRUE;
				break;
			default:
				self.active_tip_list = Constants.TRUE;
				break;
		}
	}

	self.addTip = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		/*Setting temporary params*/
		self.add.module_id = parseInt(1);
		self.add.subject_id = parseInt(1);
		self.add.subject_area_id = parseInt(1);
		self.add.link_type = "Content"
		self.add.link_id = parseInt(1);
		self.add.class_id = $scope.user.class.id;
		self.add.student_id = $scope.user.id;

		$scope.ui_block();
		StudentModuleService.addTip(self.add).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.success = Constants.FALSE;
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = Constants.TRUE;
					self.errors = Constants.FALSE;
					self.add = {};
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.tipList = function(limit, view, flag) {
		self.filters = {};
		/*setting temp params*/
		self.filters.module_id = parseInt(1);
		self.filters.link_id = (view == Constants.ALL) ? Constants.EMPTY_STR:parseInt(1);
		self.filters.link_type = "Content";
		self.filters.limit = (limit == 3) ? 3:0;

		$scope.ui_block();
		StudentModuleService.tipList(self.filters).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.tip_records = {};
					self.tip_records = response.data.records;

					angular.forEach(self.tip_records, function(value, key) {
						value.created_at = moment(value.created_at).startOf("minute").fromNow();
						value.stars = new Array(5);
					});
					self.show_btn = (response.data.total >= 4 && flag != 1) ? self.show_btn = Constants.TRUE:self.show_btn = Constants.FALSE;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.setAllActiveTip = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.active_all_tip_view = Constants.FALSE;
		self.active_all_tip_list = Constants.FALSE;
		self.active_current_view = Constants.FALSE;
		self.active_current_list = Constants.FALSE;

		switch (active) {
			case Constants.ACTIVE_VIEW :
				self.active_all_tip_view = Constants.TRUE;
				self.getTipDetails(id);
				break;
			default :
				self.active_all_tip_list = Constants.TRUE;
				self.tipList(3, Constants.ALL);
				break;
		}
	}

	self.getTipDetails = function(id) {
		$scope.ui_block();
		StudentModuleService.getTipDetails(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.details = {};
					var details = response.data;
					self.details.created_at = moment(details.created_at).startOf("minute").fromNow();
					self.details.name = details.student.first_name + ' ' + details.student.last_name;
					self.details.title = details.title;
					self.details.subject_area_name = (details.subject_area) ? details.subject_area.name:Constants.EMPTY_STR;
					self.details.subject_name = (details.subject) ? details.subject.name:Constants.EMPTY_STR;
					self.details.content = details.content;
					self.details.id = details.id;
					self.details.question_status = details.question_status;
					self.details.stars = new Array(5);
					if(self.details.question_status == Constants.ANSWERED){
						self.hide = Constants.TRUE;
					}
					self.getHelpAnswer(self.details.id);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}


	/**
	* Functions related to module
	*/
	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_questions = Constants.FALSE;
		self.active_contents = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_QUESTIONS 	:
				self.active_questions = Constants.TRUE;
				break;

			case Constants.ACTIVE_CONTENTS 	:

			default 		:
				self.active_contents = Constants.TRUE;
				break;
		}
	}

	/**
	* Updates Student Module
	*/
	var updateModuleStudent = function(data, successCallback) {
		$scope.ui_block();
		StudentModuleService.updateModuleStudent(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					if(successCallback)
						successCallback(response);
				}
			}

			$scope.ui_unblock();
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
					if(successCallback)
						successCallback(response);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});	
	}


	self.launchModule = function(module_id) {
		// get module details
		self.getModuleDetail(module_id, function(response) {
			if(response.data) {
				self.record = response.data;
				
				if(!self.record.student_module.length) {
					// create student_module
					var data = {};
						data.class_id = $scope.user.class.class_id;
						data.student_id = $scope.user.id;
						data.module_id = self.record.id;

					createModuleStudent(data, function(response) {
						if(response.data) {
							self.record.student_module[0] = response.data;	
							loadModuleView();
						} else {
							self.errors = $internalError();
						}
					});
				} else {
					loadModuleView();
				}
			} else {
				self.errors = $scope.internalError();
			}
		});
	}

	var loadModuleView = function() {
		var student_module = self.record.student_module[0];
				
		// if last_answered_question_id value is 0, load contents
		if(!student_module.last_answered_question_id) {
			self.getTeachingContents(student_module.module_id);
			self.setActive(Constants.ACTIVE_CONTENTS);
		} else {
			// if last_answered_question_id value is > 0, load question
			self.setActive(Constants.ACTIVE_QUESTIONS);
			// self.search.last_answered_question_id = student_module.last_answered_question_id;
			self.getModuleStudent(student_module.id, function(response) {
				var question = response.data.question;

				self.table.offset = question.seq_no - 1;
				self.table.page = question.seq_no; 

				getAvatarPose($scope.user.avatar_id);
				listAvatarQuotes($scope.user.avatar_id);

				self.listQuestions();	
			});
		}
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

	self.exitModule = function() {
		var data = {};
			data.module_id = self.record.student_module[0].id;

			if(self.active_contents) {
				data.last_viewed_content_id = self.contents.content_id;
			}

			if(self.active_questions) {
				data.last_answered_question_id = self.questions.id;
			}
			
		updateModuleStudent(data, function() {
			var base_url = $("#base_url_form input[name='base_url']").val();
			$window.location.href = base_url +"/student/class";
		});
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

		self.module_message = {};
		self.module_message.show = Constants.TRUE;
		self.module_message.name = self.record.name;
		self.module_message.points_to_finish = self.record.points_to_finish;
		self.module_message.badge_to_earn = self.record.badge_to_earn;
		self.module_message.skip_module = Constants.TRUE;

		$("#message_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.skipModule = function() {
		// update current view
		self.setActive(Constants.ACTIVE_QUESTIONS);

		// get question list; offset to 0
		self.listQuestions();
	}


	self.getModuleDetail = function(id, successCallback) {
		$scope.ui_block();
		StudentModuleService.getModuleDetail(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					if(successCallback)
						successCallback(response);
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

		if( self.record.student_module[0]) {
			self.search.content_id = self.record.student_module[0].last_viewed_content_id;
		}

		self.table.size = 1;

		$scope.ui_block();
		StudentModuleService.getTeachingContents(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					self.contents = response.data.records[0];
					self.contents.content_url = self.contents.teaching_content.content_url;
					self.updatePageCount(response.data);

					var data = {};
						data.module_id = self.record.student_module[0].id;

						if(self.active_contents) {
							data.last_viewed_content_id = self.contents.id;
						}

					updateModuleStudent(data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getModuleStudent = function(module_id, successCallback) {
		$scope.ui_block();
		StudentModuleService.getModuleStudent(module_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(successCallback)
						successCallback(response);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.listQuestions = function() {
		self.errors = Constants.FALSE;

		self.search.module_id = self.record.id;
		self.table.size = 1;

		$scope.ui_block();
		StudentModuleService.listQuestions(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.questions = response.data.records[0];

					var data = {};
						data.module_id = self.record.student_module[0].id;

						if(self.active_questions && self.questions) {
							data.last_answered_question_id = self.questions.id;
						}

						if(angular.equals(self.questions.question_type, Constants.ORDERING)) {
							self.questions.answer_text = self.questions.question_order_text.split(",");
						}

					updateModuleStudent(data);
					startTimer();
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function startTimer() {
		self.total_time = (self.total_time) ? self.total_time : Constants.FALSE;

		$interval(function() {
            self.total_time += 1;
        }, 1000);
	}

	self.checkAnswer = function() {
		var answer = {};

		answer.student_module_id = self.record.student_module[0].id;
		answer.module_id = self.record.id;
		answer.seq_no = self.questions.seq_no;
		answer.question_id = self.questions.id;
		answer.answer_id = self.questions.answer_id;
		answer.student_id = $scope.user.id;
		answer.total_time = self.total_time;
		answer.date_start = $filter('date')(new Date() - (answer.total_time * 1000), 'yyyyMMdd');
		answer.date_end = $filter('date')(new Date(), 'yyyyMMdd');
		answer.answer_text = (angular.equals(self.questions.question_type, Constants.ORDERING)) ? self.questions.answer_text.join(",") : self.questions.answer_text;		

		StudentModuleService.answerQuestion(answer).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.search.difficulty = response.data.current_difficulty_level;
					self.nextQuestion();
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.selectAnswer = function(object) {
		self.questions.answer_id = object.id;
	}

	self.nextQuestion = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		var page = self.table.page + 1;
		self.search.last_answered_question_id = Constants.EMPTY_STR;

		self.table.page = (page < Constants.DEFAULT_PAGE) ? Constants.DEFAULT_PAGE : page;
		self.table.offset = (page - 1) * self.table.size;
		self.listQuestions();
	}

	self.updateBackground = function() {
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
}