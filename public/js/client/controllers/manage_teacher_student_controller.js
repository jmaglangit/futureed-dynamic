angular.module('futureed.controllers')
	.controller('ManageTeacherStudentController', ManageTeacherStudentController);

ManageTeacherStudentController.$inject = ['$scope', 'manageTeacherStudentService', 'apiService', 'TableService', 'SearchService'];

function ManageTeacherStudentController($scope, manageTeacherStudentService, apiService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active) {
		self.errors = Constants.FALSE;
		
		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_VIEW:
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT:
				self.active_edit = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST:
			default:
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.list = function() {
		if(self.active_list) {
			self.listStudent();
		}
	}

	self.searchFnc = function() {
		self.tableDefaults();
		self.list();
	}

	self.clearSearch = function() {
		self.searchDefaults();
		self.tableDefaults();

		self.list();
	}

	self.listStudent = function() {
		self.records = [];
		self.search.client_role = Constants.TEACHER;

		$scope.ui_block();
		manageTeacherStudentService.listStudent(self.search, self.table).success(function(response) {
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

	self.studentDetails = function(id, active) {
		self.record = {};

		$scope.ui_block();
		manageTeacherStudentService.studentDetails(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var data = response.data;

					self.record = data;
					self.record.username = data.user.username;
					self.record.email = data.user.email;
					self.record.new_email = data.user.new_email;
					self.record.birth = data.birth_date;
					self.setActive(active);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}