angular.module('futureed.controllers')
	.controller('ManageParentReportsController', ManageParentReportsController);

ManageParentReportsController.$inject = ['$scope', '$timeout', 'ManageParentReportsService', 'SearchService'];

function ManageParentReportsController($scope, $timeout, ManageParentReportsService, SearchService) {
	var self = this;
	SearchService(self);
    self.searchDefaults();

	self.setActive = function (active) {
		self.records = {};
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.active_report_card = Constants.FALSE;
		self.active_summary_progress = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_current_learning = Constants.FALSE;
		self.active_subject_area = Constants.FALSE;

		self.searchDefaults();

		switch (active) {
			case Constants.SUMMARY_PROGRESS    :
				self.active_summary_progress = Constants.TRUE;
				self.listSubjects();
				break;

			case Constants.REPORT_CARD            :
				self.active_report_card = Constants.TRUE;
				self.reportCard();
				break;

			case Constants.CURRENT_LEARNING        :
				console.log('it works');
				self.active_current_learning = Constants.TRUE;
				self.listLearning();
				break;

			case Constants.SUBJECT_AREA            :
				self.active_subject_area = Constants.TRUE;
				self.listSubjectAreaSubject();
				break;

			default                                :
				self.active_report_card = Constants.TRUE;
				self.reportCard();
				break;
		}
	}

	self.reportCard = function () {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageParentReportsService.reportCard($scope.user.id).success(function (response) {
			if (angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if (response.data) {
					self.records = response.data.rows;
					self.student = response.data.additional_information;
				}
			}

			$scope.ui_unblock();
		}).error(function (response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.summaryProgress = function (subject_id) {
		self.errors = Constants.FALSE;
		self.summary = {};

		self.search.subject_id = (self.search.subject_id) ? self.search.subject_id : subject_id;

		$scope.ui_block();
		ManageParentReportsService.summaryProgress($scope.user.id, self.search.subject_id).success(function (response) {
			if (angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if (response.data) {
					self.summary.columns = response.data.column_header[0];

					$timeout(function () {
						self.summary.records = response.data.rows.progress;
						self.student = response.data.additional_information;

						angular.forEach(self.summary.records, function (value, key) {
							value.completed = value.completed + "%";
							value.on_going = value.on_going + "%";
						});
					}, 500);
				}
			}

			$scope.ui_unblock();
		}).error(function (response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.listSubjects = function () {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageParentReportsService.listClass($scope.user.id).success(function (response) {
			if (angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if (response.data) {
					var data = response.data.records;
					if (data.length) {
						self.subjects = [];

						angular.forEach(data, function (value, key) {
							self.subjects[key] = value.classroom.subject;
						});

						self.summaryProgress(self.subjects[0].id);
					}
				}
			}

			$scope.ui_unblock();
		}).error(function (response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.listLearning = function () {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageParentReportsService.listClass($scope.user.id).success(function (response) {
			if (angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if (response.data) {
					var data = response.data.records;
					if (data.length) {
						self.subjects = [];

						angular.forEach(data, function (value, key) {
							self.subjects[key] = value.classroom.subject;
						});

						self.currentLearning(self.subjects[0].id);
					}
				}
			}

			$scope.ui_unblock();
		}).error(function (response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.currentLearning = function (subject_id) {
		self.errors = Constants.FALSE;
		self.summary = {};
		self.grade_name = '';


		self.search.subject_id = (self.search.subject_id) ? self.search.subject_id : subject_id;

		$scope.ui_block();
		ManageParentReportsService.currentLearning($scope.user.id, self.search.subject_id).success(function (response) {
			if (angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if (response.data) {
					self.summary.columns = response.data.column_header;

					self.row_data = {};
					var data = response.data.rows;
					var raw_grade = 0;

					angular.forEach(data, function (value, key) {

						if (value.grade_id == raw_grade) {

							value.grade_name = '';
							self.row_data[key] = value;
						} else {

							raw_grade = value.grade_id;
						}
					});

					self.summary.records = response.data.rows;
				}
			}

			$scope.ui_unblock();
		}).error(function (response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.listSubjectAreaSubject = function () {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageParentReportsService.listClass($scope.user.id).success(function (response) {
			if (angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if (response.data) {
					var data = response.data.records;
					if (data.length) {
						self.subjects = [];

						angular.forEach(data, function (value, key) {
							self.subjects[key] = value.classroom.subject;
						});

						self.subjectArea(self.subjects[0].id);
					}
				}
			}

			$scope.ui_unblock();
		}).error(function (response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.subjectArea = function (subject_id) {
		self.errors = Constants.FALSE;
		self.summary = {};

		self.search.subject_id = (self.search.subject_id) ? self.search.subject_id : subject_id;

		$scope.ui_block();
		ManageParentReportsService.subjectArea($scope.user.id, self.search.subject_id).success(function (response) {
			if (angular.equals(response.status, Constants.STATUS_OK)) {
				if (response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if (response.data) {
					self.summary.columns = response.data.column_header;
			
					var column = response.data.column_header;

					angular.forEach(column, function (value, key){


					});

					self.summary.records = response.data.rows;
					self.student = response.data.additional_information;
				}
			}

			$scope.ui_unblock();
		}).error(function (response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}