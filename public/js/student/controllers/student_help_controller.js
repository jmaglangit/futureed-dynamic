angular.module('futureed.controllers')
	.controller('HelpController', HelpController);

HelpController.$inject = ['$scope', 'apiService', 'StudentHelpService', 'TableService', 'SearchService'];

function HelpController($scope, apiService, StudentHelpService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, id, flag) {
		self.errors = Constants.FALSE;
		if(flag != 1) {
			self.success = Constants.FALSE;
		}
		
		self.record = {};

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_VIEW:
				self.helpDetail(id);
				self.listAnswers(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST:
				self.active_list = Constants.TRUE;
				break;

			default:
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.setRequestType = function(request_type, help_id) {
		self.search.help_request_type = request_type;

		if(help_id) {
			self.setActive(Constants.ACTIVE_VIEW, help_id);
		}
	}

	self.searchFnc = function(event) {
		self.success = Constants.FALSE;

		self.tableDefaults();
		self.list();

		event = getEvent(event);
		event.preventDefault();
	}

	self.clearFnc = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.searchDefaults();
		self.tableDefaults();

		self.list();
	}

	self.list = function() {
		if(self.active_list) {
			self.listHelp();
		}
	}

	self.listHelp = function() {
		self.records = [];
		self.errors = Constants.FALSE;
		if (self.search.help_request_type) {
			self.search.student_id = $scope.user.id;
		}

		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		StudentHelpService.list(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.records;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.helpDetail = function(id) {
		self.errors = Constants.FALSE;
		self.hovered = [];
		self.record = {};

		$scope.ui_block();
		StudentHelpService.detail(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var record = response.data;

					self.record.id = record.id;
					self.record.created_moment = moment(record.created_at).startOf("minute").fromNow();
					self.record.stars = new Array(5);
					
					self.record.avatar_url = '/images/thumbnail/' + record.student.avatar.avatar_image;
					self.record.title = record.title;
					self.record.content = record.content;
					self.record.rating = record.rating;
					self.record.own = (record.student_id == $scope.user.id) ? Constants.TRUE : Constants.FALSE;
					self.record.question_status = record.question_status;
					self.record.student_id = record.student_id;
					self.record.name = record.student.first_name + " " + record.student.last_name;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.listAnswers = function(id) {
		self.answers = [];
		self.errors = Constants.FALSE;

		StudentHelpService.listAnswers(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.answers = response.data.records;

					angular.forEach(self.answers, function(value, key) {
						value.created_moment = moment(value.updated_at).startOf("minute").fromNow();
						value.answer_av = '/images/thumbnail/' + value.student.avatar.avatar_image;
						value.stars = new Array(5);
					});
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.changeColor = function(index, answer_id) {
		self.hovered[answer_id] = [];

		for (i = 0; i <= index; i++ ) {
			self.hovered[answer_id][i] = Constants.TRUE;			
		}
	}

	self.selectRate = function(index, answer_id) {
		self.errors = Constants.FALSE;

		var data = {};
			data.student_id = $scope.user.id;
			data.help_request_answer_id = answer_id;
			data.rating = self.hovered[answer_id].length;

		$scope.ui_block();
		StudentHelpService.rate(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.answers[index].rating = data.rating;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.deleteRequest = function(module) {
		var data = {};
			data.id = self.record.id;
			data.question_status = Constants.CANCELLED;

		updateStatus(data, module);
	}

	self.closeRequest = function(module) {
		var data = {};
			data.id = self.record.id;
			data.question_status = Constants.ANSWERED;

		updateStatus(data, module);
	}

	function updateStatus(data, module) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		StudentHelpService.updateStatus(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(module) {
						self.setModuleActive(Constants.ACTIVE_VIEW, self.record.id);
					} else {
						self.setActive(Constants.ACTIVE_VIEW, self.record.id);
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.clearAnswer = function() {
		self.errors = Constants.FALSE;
		self.record.answer = Constants.EMPTY_STR;
	}

	self.answerRequest = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		var data = {};
			data.content = self.record.answer;
			data.student_id = $scope.user.id;
			data.help_request_id = self.record.id;

		$scope.ui_block();
		StudentHelpService.answerRequest(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = studentHelp.ANSWER_SUCCESS;
					self.setActive(Constants.ACTIVE_VIEW, self.record.id, 1);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	/**
	* Related to Contents / Questions
	*/
	self.setModuleActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.record = {};

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_add = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_VIEW:
				self.moduleHelpDetail(id);
				self.listAnswers(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST:
				self.active_list = Constants.TRUE;
				break;

			case Constants.ACTIVE_ADD:
				self.active_add = Constants.TRUE;
				break;

			default:
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}


	$scope.$on('toggle-help', function(event) {
		var self = event.currentScope.help;
		var module = event.targetScope.mod;


		if(!self.show_help_requests) {
			self.show_help_requests = !self.show_help_requests;
		}

		self.module_instance = module;
		self.module = module.record;
		self.question = module.current_question;
		self.content = module.contents;

		self.setModuleActive(Constants.ACTIVE_ADD);
	});

	self.viewHelpList = function() {
		self.setModuleActive();

		if(!self.active_own && !self.active_classmate 
			&& !self.active_current && !self.active_all) {
			self.setHelpTabActive();
		}
	}

	self.toggleHelp = function(module) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.show_help_requests = !self.show_help_requests;
		
		self.module_instance = module;
		self.module = module.record;
		self.question = module.current_question;
		self.content = module.contents;

		self.setModuleActive();
		self.setHelpTabActive();
	}

	self.setHelpTabActive = function(active) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.search.module_id= self.module.id;
		
		self.search.student_id= $scope.user.id;
		self.search.question_status = Constants.EMPTY_STR;

		if(!self.active_all) {
			self.search.link_type = (self.module_instance.active_questions) ? Constants.QUESTION : Constants.CONTENT;
			self.search.link_id = (angular.equals(self.search.link_type, Constants.QUESTION)) ? self.question.id : self.content.id;
		}

		switch(active) {
			case Constants.CLASSMATE 	:
				self.active_classmate = Constants.TRUE;
				self.active_own = Constants.FALSE;

				self.search.help_request_type = StudentModuleConstants.OTHERS;
				break;

			case Constants.OWN 			:
				self.active_own = Constants.TRUE;
				self.active_classmate = Constants.FALSE;

				self.search.help_request_type = StudentModuleConstants.OWN;
				break;

			case Constants.CURRENT 		:
				self.active_current = Constants.TRUE;
				self.active_all = Constants.FALSE;

				self.search.link_type = (self.module_instance.active_questions) ? Constants.QUESTION : Constants.CONTENT;
				self.search.link_id = (angular.equals(self.search.link_type, Constants.QUESTION)) ? self.question.id : self.content.id;
				break;

			case Constants.ALL 			:
				self.active_all = Constants.TRUE;
				self.active_current = Constants.FALSE;

				self.search.link_type = Constants.EMPTY_STR;
				self.search.link_id = Constants.EMPTY_STR;
				break;

			default 	:
				self.active_classmate = Constants.TRUE;
				self.active_own = Constants.FALSE;

				self.active_current = Constants.TRUE;
				self.active_all = Constants.FALSE;

				self.search.help_request_type = StudentModuleConstants.OTHERS;
				break;
		}

		self.listContentHelp();
	}

	self.listContentHelp = function() {
		$scope.div_block('help_request_list');
		StudentHelpService.list(self.search).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.records;

					angular.forEach(self.records, function(value, key) {
						value.created_at = moment(value.created_at).startOf("minute").fromNow();
					});

					self.updatePageCount(response.data);
				}
			}

			$scope.div_unblock('help_request_list');
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.div_unblock('help_request_list');
		});
	}

	self.moduleHelpDetail = function(id) {
		self.errors = Constants.FALSE;
		self.record = {};

		$scope.div_block('help_request_details');
		StudentHelpService.detail(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var record = response.data;

					self.record.id = record.id;
					self.record.created_moment = moment(record.created_at).startOf("minute").fromNow();
					self.record.stars = new Array(5);
					
					self.record.avatar_url = record.student.avatar.avatar_url;
					self.record.title = record.title;
					self.record.content = record.content;
					self.record.request_status = record.request_status;

					self.record.subject_area_name = (record.subject_area) ? record.subject_area.name : Constants.EMPTY_STR;
					self.record.subject_name = (record.subject) ? record.subject.name : Constants.EMPTY_STR;

					self.record.rating = record.rating;
					self.record.own = (record.student_id == $scope.user.id) ? Constants.TRUE : Constants.FALSE;
					self.record.question_status = record.question_status;
					self.record.student_id = record.student_id;
					self.record.name = record.student.first_name + " " + record.student.last_name;
				}
			}

			$scope.div_unblock('help_request_details');
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.div_unblock('help_request_details');
		});
	}

	self.addHelp = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.record.module_id = self.module.id;
		self.record.subject_id = self.module.subject_id;
		self.record.subject_area_id = self.module.subject_area_id;
		self.record.link_type = (self.active_questions) ? Constants.QUESTION : Constants.CONTENT;
		self.record.link_id = (angular.equals(self.record.link_type, Constants.QUESTION)) ? self.question.id : self.content.id;
		self.record.class_id = self.module.student_module[0].class_id;
		self.record.student_id = $scope.user.id;

		$scope.div_block('help_request_list');
		StudentHelpService.addHelp(self.record).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.record = {};
					self.success = Constants.TRUE;
				}
			}

			$scope.div_unblock('help_request_list');
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.div_unblock('help_request_list');
		})
	}
}
