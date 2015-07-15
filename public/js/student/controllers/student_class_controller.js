angular.module('futureed.controllers')
	.controller('StudentClassController', StudentClassController);

StudentClassController.$inject = ['$scope', '$filter', 'StudentClassService'];

function StudentClassController($scope, $filter, StudentClassService) {

	var self = this;

	self.tips = {};
	self.help = {};
	self.student_id = $scope.user.id;

	self.redirectHelp = function(help_id) {
		$("#redirect_help input[name='id']").val(help_id);
		$("#redirect_help").submit();
	}

	self.redirectTip = function(help_id) {
		$("#redirect_tip input[name='id']").val(help_id);
		$("#redirect_tip").submit();
	}

	self.click = function() {
		self.add_tips = Constants.FALSE;
		self.bool_change_class = !self.bool_change_class;
		if(self.bool_change_class) {
			self.listTips();
			self.listHelpRequests();
		}
	}

	self.addTips = function() {
		self.add_tip_class = !self.add_tip_class;
		self.add_tips = Constants.TRUE;
		self.tips.success = Constants.FALSE;
		self.alert = Constants.FALSE;
		self.tips = {};
	}

	self.backTips = function() {
		self.tips = {};
		self.add_tips = Constants.FALSE;
		self.add_tip_class = Constants.FALSE;

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
					self.tips.errors = Constants.FALSE;
					self.add_tips = Constants.FALSE;
				}
			}
			$scope.div_unblock("tips_form");
		}).error(function(response){
			$scope.internalError();
			$scope.div_unblock("tips_form");
		})
	}

	self.addHelp = function() {
		self.help = {};
		self.add_help = Constants.TRUE;
		self.help.success = Constants.FALSE;
		self.help.errors = Constants.FALSE;
		self.alert = Constants.FALSE;
	}

	self.submitHelp = function() {
		self.help.errors = Constants.FALSE;
		self.help.success = Constants.FALSE;
		self.help.student_id = self.student_id;
		self.help.class_id = Constants.FALSE;

		$scope.div_block("help_request_form");
		StudentClassService.submitHelp(self.help).success(function(response){
		self.alert = Constants.TRUE;
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.help.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.help.success = Constants.TRUE;
					self.help.errors = Constants.FALSE;
					self.add_help = Constants.FALSE;
				}
			}
			$scope.div_unblock("help_request_form");
		}).error(function(response){
			$scope.internalError();
			$scope.div_unblock("help_request_form");
		})
	}

	self.backHelp = function() {
		self.help = {};
		self.add_help = Constants.FALSE;
		self.add_help_class = Constants.FALSE;

		self.listHelpRequests();
	}

	self.listTips = function() {
		self.errors = Constants.FALSE;
		self.class_id = ($scope.user.class) ? $scope.user.class.class_id : Constants.EMPTY_STR;
		
		self.table = {};
		self.table.size = 3;
		self.table.offset = Constants.FALSE;

		$scope.div_block("tips_form");
		StudentClassService.listTips(self.class_id, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					$scope.errorHandler(response.errors);
				} else if(response.data) {
					self.tip = {};
					self.tip.records = [];
					self.tip.total = response.data.total;

					angular.forEach(response.data.records, function(value, key) {
						value.created_moment = moment(value.created_at).startOf("minute").fromNow();
						value.stars = new Array(5);

						self.tip.records.push(value);
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
		StudentClassService.listHelpRequests(self.search, self.table).success(function(response) {
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
}