angular.module('futureed.controllers')
	.controller('StudentReportsController', StudentReportsController);

StudentReportsController.$inject = ['$scope', '$timeout', 'StudentReportsService', 'SearchService'];

function StudentReportsController($scope, $timeout, StudentReportsService, SearchService) {
	var self = this;

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active) {
		self.records = {};
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.active_report_card = Constants.FALSE;
		self.active_summary_progress = Constants.FALSE;
		self.active_add = Constants.FALSE;

		self.searchDefaults();

		switch(active) {
			case	Constants.SUMMARY_PROGRESS	:
				self.active_summary_progress = Constants.TRUE;
				self.listSubjects();
				break;

			case Constants.REPORT_CARD			:

			default								:
				self.active_report_card = Constants.TRUE;
				self.reportCard();
				break;
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
					self.student = response.data.additional_information;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.summaryProgress = function(subject_id) {
		self.errors = Constants.FALSE;
		self.summary = {};

		self.search.subject_id = (self.search.subject_id) ? self.search.subject_id : subject_id;

		$scope.ui_block();
		StudentReportsService.summaryProgress($scope.user.id, self.search.subject_id).success(function(response) {
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
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.listSubjects = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		StudentReportsService.listClass($scope.user.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var data = response.data.records;
					if(data.length) {
						self.subjects = [];

						angular.forEach(data, function(value, key) {
							self.subjects[key] = value.classroom.subject;
						});

						self.summaryProgress(self.subjects[0].id);
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}