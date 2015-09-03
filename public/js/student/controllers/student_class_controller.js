angular.module('futureed.controllers')
	.controller('StudentClassController', StudentClassController);

StudentClassController.$inject = ['$scope', '$filter', '$window', 'StudentClassService', 'SearchService', 'TableService'];

function StudentClassController($scope, $filter, $window, StudentClassService, SearchService, TableService) {
	var self = this;

	self.tips = {};
	self.help = {};

	SearchService(self);
	self.searchDefaults();

	TableService(self);
	self.tableDefaults();

	self.redirectHelp = function(help_id) {
		$("#redirect_help input[name='id']").val(help_id);
		$("#redirect_help").submit();
	}

	self.redirectTip = function(help_id) {
		$("#redirect_tip input[name='id']").val(help_id);
		$("#redirect_tip").submit();
	}

	self.click = function() {
		self.bool_change_class = !self.bool_change_class;

		if(self.bool_change_class) {
			self.add_tips = Constants.FALSE;
			self.add_help = Constants.FALSE;

			self.listTips();
			self.listHelpRequests();
		}
	}

	self.addTips = function() {
		self.tips = {};
		self.add_tips = Constants.TRUE;
	}

	self.backTips = function() {
		self.tips = {};
		self.add_tips = Constants.FALSE;

		self.listTips();
	}

	self.submitTips = function() {
		self.tips.errors = Constants.FALSE;
		self.tips.success = Constants.FALSE;
		self.tips.student_id = $scope.user.id;

		$scope.div_block("tips_form");
		StudentClassService.submitTips(self.tips).success(function(response){
		self.alert = Constants.TRUE;
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.tips.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.tips.success = Constants.TRUE;
					self.add_tips = Constants.FALSE;
				}
			}
			$scope.div_unblock("tips_form");
		}).error(function(response){
			self.tips.errors = $scope.internalError();
			$scope.div_unblock("tips_form");
		})
	}

	self.addHelp = function() {
		self.help = {};
		self.add_help = Constants.TRUE;
	}

	self.backHelp = function() {
		self.help = {};
		self.add_help = Constants.FALSE;

		self.listHelpRequests();
	}

	self.submitHelp = function() {
		self.help.errors = Constants.FALSE;
		self.help.success = Constants.FALSE;
		self.help.student_id = $scope.user.id;
		self.help.class_id = $scope.user.class_id.class_id;

		$scope.div_block("help_request_form");
		StudentClassService.submitHelp(self.help).success(function(response){
		self.alert = Constants.TRUE;
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.help.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.help.success = Constants.TRUE;
					self.add_help = Constants.FALSE;
				}
			}
			$scope.div_unblock("help_request_form");
		}).error(function(response){
			self.help.errors = $scope.internalError();
			$scope.div_unblock("help_request_form");
		})
	}
	// API changes object class to class_id
	self.listTips = function() {
		self.errors = Constants.FALSE;
		self.class_id = ($scope.user.class_id) ? $scope.user.class_id.class_id : Constants.EMPTY_STR;
		
		self.table = {};
		self.table.size = 3;
		self.table.offset = Constants.FALSE;

		$scope.div_block("tips_form");
		StudentClassService.listTips(self.class_id, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					$scope.errorHandler(response.errors);
				} else if(response.data) {
					self.tips = {};
					self.tips.records = response.data.records;
					self.tips.total = response.data.total;

					angular.forEach(response.data.records, function(value, key) {
						value.created_moment = moment(value.created_at).startOf("minute").fromNow();
						value.stars = new Array(5);
					});
				}
			}

			$scope.div_unblock("tips_form");
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.div_unblock("tips_form");
		});
	}

	self.listHelpRequests = function() {
		self.errors = Constants.FALSE;

		self.search = {};
		self.search.order_by_date = Constants.TRUE;
		self.search.request_status = Constants.ACCEPTED;

		self.table = {};
		self.table.size = 3;
		self.table.offset = Constants.FALSE;

		$scope.div_block("help_request_form");
		StudentClassService.listHelpRequests($scope.user.class_id.class_id, self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					$scope.errorHandler(response.errors);
				} else if(response.data) {
					self.help = {};
					self.help.records = [];
					self.help.total = response.data.total;

					angular.forEach(response.data.records, function(value, key) {
						value.created_moment = moment(value.created_at).startOf("minute").fromNow();
						value.stars = new Array(5);

						self.help.records.push(value);
					});
				}
			}

			$scope.div_unblock("help_request_form");
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.div_unblock("help_request_form");
		});
	}

	self.searchFnc = function(event) {
		self.errors = Constants.FALSE;
		self.tableDefaults();
		self.list();
		
		event = getEvent(event);
		event.preventDefault();
	}

	self.clearFnc = function() {
		self.errors = Constants.FALSE;

		self.searchDefaults();
		self.tableDefaults();
		self.list();
	}

	self.list = function() {
		self.listModules();
	}

	self.listClass = function() {
		self.errors = Constants.FALSE;
		var student_id = $scope.user.id;

		$scope.ui_block();
		StudentClassService.listClass(student_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.classes = response.data.records;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.selectClass = function(class_id) {
		self.searchDefaults();
		self.tableDefaults();
		
		self.listModules(class_id);
	}

	self.listModules = function(class_id) {
		self.errors = Constants.FALSE;
		self.records = [];
		self.table.loading = Constants.TRUE;

		self.current_class = (class_id) ? class_id : self.current_class;
		self.search.class_id = self.current_class;
		self.search.student_id = $scope.user.id;

		$scope.ui_block();
		StudentClassService.listModules(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.student_classroom.student_subject.student_modules.records;
					self.updatePageCount(response.data);

					angular.forEach(self.records, function(value, key) {
						value.progress = (value.progress) ? value.progress : Constants.FALSE;
					});
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getSubjects = function() {
		StudentClassService.getSubjects().success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.subjects = response.data.records;
				}
			}

		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.redirect = function(url, record) {
		if($scope.user.points >= record.points_to_unlock) {
			url += "/" + record.id;
			$window.location.href = url;
		}
	}

	self.updateBackground = function() {
		angular.element('body.student').css({
			'background-image' : 'url("/images/class-student/mountain-full-bg.png")'
		});
	}
}