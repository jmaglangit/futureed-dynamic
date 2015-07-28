angular.module('futureed.controllers')
	.controller('StudentModuleController', StudentModuleController);

StudentModuleController.$inject = ['$scope', '$window', '$interval', 'apiService', 'StudentModuleService', 'SearchService', 'TableService'];

function StudentModuleController($scope, $window, $interval, apiService, StudentModuleService, SearchService, TableService) {
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

	self.setTipTabActive = function(view) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.current_tips_view = view;
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

	self.setCurrentActiveTip = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.active_current_tip_view = Constants.FALSE;
		self.active_current_tip_list = Constants.FALSE;
		self.active_all_tip_view = Constants.FALSE;
		self.active_all_tip_list = Constants.FALSE;

		switch (active) {
			case Constants.ACTIVE_VIEW :
				self.active_current_tip_view = Constants.TRUE;
				self.getTipDetails(id);
				break;
			default :
				self.active_current_tip_list = Constants.TRUE;
				self.tipList(3, Constants.CURRENT);
				break;
		}
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


	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_questions = Constants.FALSE;
		self.active_contents = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_QUESTIONS 	: 
				self.active_questions = Constants.TRUE;
				break;

			case Constants.CONTENTS 	:
				self.getTeachingContents(id);
				self.getModuleDetail(id);

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
					successCallback();
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
					successCallback();
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});	
	}


	self.getModuleDetail = function(id) {
		if(id) {
			$scope.ui_block();
			StudentModuleService.getModuleDetail(id).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else {
						self.record = response.data;

						if(!self.record) {
							self.errors = [Constants.MSG_NO_RECORD];
							self.no_record = Constants.TRUE;
						} else {
							if(!self.record.student_module.length) {
								var data = {};
									data.student_id =  $scope.user.id;
									data.module_id =  self.record.id;
									data.class_id =  $scope.user.class.class_id;

									createModuleStudent(data, function() {});
							}
						}
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		} else {
			self.errors = [Constants.MSG_NO_RECORD];
			self.no_record = Constants.TRUE;
		}
	}

	self.paginateContent = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		var page = self.table.page;

		self.table.page = (page < Constants.DEFAULT_PAGE) ? Constants.DEFAULT_PAGE : page;
		self.table.offset = (page - 1) * self.table.size;
		self.getTeachingContents(self.search.module_id);

	}

	self.getTeachingContents = function(id) {
		if(id) {
			self.search.module_id = id;
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
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		} else {
			self.errors = [Constants.MSG_NO_RECORD];
			self.no_record = Constants.TRUE;
		}
	}

	self.exitModule = function() {
		var data = {};
			data.module_id = (self.contents) ? self.contents.module_id : Constants.EMPTY_STR;
			data.last_viewed_content_id = (self.active_contents) ? self.contents.content_id : Constants.EMPTY_STR;
			data.last_answered_question_id = (self.active_questions) ? self.questions.id : Constants.EMPTY_STR;

			updateModuleStudent(data, function() {
				var base_url = $("#base_url_form input[name='base_url']").val();
				$window.location.href = base_url +"/student/class";
			});		
	}

	self.skipModule = function() {
		var data = {};
			data.module_id = (self.contents) ? self.contents.module_id : Constants.EMPTY_STR;
			data.last_viewed_content_id = (self.active_contents) ? self.contents.content_id : Constants.EMPTY_STR;

			updateModuleStudent(data, function() {
				// set view to question list
				self.setActive(Constants.ACTIVE_QUESTIONS);
				// get question list
				self.listQuestions();
			});	
	}

	self.startQuestions = function(object) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.module_message = {};
		self.module_message.show = Constants.TRUE;

		$("#message_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.listQuestions = function() {
		self.errors = Constants.FALSE;

		self.search.module_id = self.record.id;
		self.search.difficulty = (self.search.difficulty) ? self.search.difficulty : 1;

		self.table.size = 1;

		$scope.ui_block();
		StudentModuleService.listQuestions(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.questions = response.data.records[0];
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
		answer.answer_text = self.questions.answer_text;

		console.log();

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

		self.table.page = (page < Constants.DEFAULT_PAGE) ? Constants.DEFAULT_PAGE : page;
		self.table.offset = (page - 1) * self.table.size;
		self.listQuestions();
	}
}