angular.module('futureed.controllers')
	.controller('ManageTeacherStudentController', ManageTeacherStudentController);

ManageTeacherStudentController.$inject = ['$scope', '$filter', 'manageTeacherStudentService', 'apiService', 'TableService', 'SearchService', 'ValidationService'];

function ManageTeacherStudentController($scope, $filter, manageTeacherStudentService, apiService, TableService, SearchService, ValidationService) {
	var self = this;

	ValidationService(self);
	self.default();

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.fields = [];
		
		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_email = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_VIEW:
				self.active_view = Constants.TRUE;
				self.studentDetails(id);
				break;

			case Constants.ACTIVE_EDIT:
				self.success = Constants.FALSE;
				self.active_edit = Constants.TRUE;
				self.studentDetails(id);
				break;

			case Constants.ACTIVE_EMAIL:
				self.change = {};
				self.validation = {};
				self.success = Constants.FALSE;
				self.active_email = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST:
			default:
				self.success = Constants.FALSE;
				self.active_list = Constants.TRUE;
				break;
		}

		$("input, select").removeClass("required-field");
		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.list = function() {
		if(self.active_list) {
			self.listStudent();
		}
	}

	self.searchFnc = function(event) {
		self.tableDefaults();
		self.list();

		event = getEvent(event);
		event.preventDefault();
	}

	self.clearSearch = function() {
		self.searchDefaults();
		self.tableDefaults();

		self.list();
	}

	self.listStudent = function() {
		self.records = [];
		self.search.client_role = Constants.TEACHER;
		self.search.client_id = $scope.user.id;

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

	self.studentDetails = function(id) {
		self.errors = Constants.FALSE;
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
					
					self.dateDropdown(self.record.birth_date);
					self.getGradeLevel(self.record.country_id)
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateDetails = function() {
		self.fields = [];
		self.errors = Constants.FALSE;
		
		$("div.birth-date-wrapper select").removeClass("required-field");

		var birth_date = $("input#birth_date").val();
		self.record.birth_date = $filter(Constants.DATE)(new Date(birth_date), Constants.DATE_YYYYMMDD);

		$scope.ui_block();
		manageTeacherStudentService.updateDetails(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});

					if(self.fields['birth_date']) {
		            	$("div.birth-date-wrapper select").addClass("required-field");
		            }
				} else if(response.data) {
					var data = response.data;

					self.record = data;
					self.record.username = data.user.username;
					self.record.email = data.user.email;
					self.record.new_email = data.user.new_email;
					self.record.birth = data.birth_date;
					
					self.success = TeacherConstant.UPDATE_STUDENT_SUCCESS;
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateEmail = function() {
		self.fields = [];
		self.errors = Constants.FALSE;

		self.data = {};
		self.data.student_id = self.record.id;
		self.data.email = self.change.current_email;
		self.data.new_email = self.change.new_email;
		self.data.password = self.change.password;
		self.data.client_id = $scope.user.id;

		var base_url = $("#base_url_form input[name='base_url']").val();
		self.data.callback_uri = base_url + Constants.URL_CHANGE_EMAIL(angular.lowercase(Constants.STUDENT));

		$scope.ui_block();
		manageTeacherStudentService.updateEmail(self.data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.success = TeacherConstant.UPDATE_STUDENT_EMAIL_SUCCESS;
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getGradeLevel = function(country_id) {
		$scope.getGradeLevel(country_id);
	}

	self.dateDropdown = function(date) {
		$("#birth_date").dateDropdowns({
			defaultDate : date,
		    submitFieldName: 'birth_date',
		    wrapperClass: 'birth-date-wrapper',
		    minAge: Constants.MIN_AGE,
		    maxAge: Constants.MAX_AGE
		});

		if(self.active_edit) {
			$(".day, .month, .year").prop('disabled', false);
		}else {
			$(".day, .month, .year").prop('disabled', true);
		}
	}
}