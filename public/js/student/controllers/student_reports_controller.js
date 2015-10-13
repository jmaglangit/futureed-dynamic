angular.module('futureed.controllers')
	.controller('StudentReportsController', StudentReportsController);

StudentReportsController.$inject = ['$scope', '$timeout', 'StudentReportsService', 'TableService', 'SearchService'];

function StudentReportsController($scope, $timeout, StudentReportsService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active) {
		self.records = {};
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.active_report_card = Constants.FALSE;
		self.active_summary_progress = Constants.FALSE;
		self.active_add = Constants.FALSE;

		self.tableDefaults();
		self.searchDefaults();

		switch(active) {
			case	Constants.SUMMARY_PROGRESS	:
				self.active_summary_progress = Constants.TRUE;
				self.summaryProgress();
				break;

			case Constants.REPORT_CARD			:

			default								:
				self.active_report_card = Constants.TRUE;
				self.reportCard();
				break;
		}
	}

	self.list = function() {
		if(self.active_report_card) {
			self.reportCard();
		} else if(self.active_summary_progress) {
			self.summaryProgress();
		}
	}

	self.reportCard = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		StudentReportsService.reportCard($scope.user.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.rows;
					// self.updatePageCount(response.data.total);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.summaryProgress = function() {
		self.errors = Constants.FALSE;
		self.summary = {};

		$scope.ui_block();
		StudentReportsService.summaryProgress($scope.user.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.summary.columns = response.data.column_header;

					$timeout(function() {
						self.summary.records = response.data.rows;

						angular.forEach(self.summary.records, function(value, key) {
							value.completed = value.completed + "%";
							value.on_going = value.on_going + "%";
						});
					}, 500);
					// self.updatePageCount(response.data.total);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}