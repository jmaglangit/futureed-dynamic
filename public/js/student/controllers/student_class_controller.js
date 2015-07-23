angular.module('futureed.controllers')
	.controller('StudentClassController', StudentClassController);

StudentClassController.$inject = ['$scope', '$filter', 'StudentClassService', 'SearchService', 'TableService'];

function StudentClassController($scope, $filter, StudentClassService, SearchService, TableService) {
	var self = this;

	self.tips = {};
	self.help = {};
	self.student_id = $scope.user.id;

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
		self.tips.student_id = self.student_id;

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
		self.help.student_id = self.student_id;
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
					self.tips.records = [];
					self.tips.total = response.data.total;

					angular.forEach(response.data.records, function(value, key) {
						value.created_moment = moment(value.created_at).startOf("minute").fromNow();
						value.stars = new Array(5);

						self.tips.records.push(value);
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

	self.listModules = function() {
		self.errors = Constants.FALSE;
		self.records = [];
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		StudentClassService.listModules(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.records;
					self.updatePageCount(response.data);

					angular.forEach(self.records, function(value, key) {
						value.slug_name = formatSlug(value.name);
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

	self.redirect = function(event, url, slug_name) {
		event = getEvent(event);
		event.preventDefault();

		url += "/" + slug_name;
		$("#search_form").attr('action', url);
		$("#search_form").attr('method', Constants.METHOD_POST);
		$("#search_form").trigger('submit');
	}
}