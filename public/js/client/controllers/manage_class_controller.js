angular.module('futureed.controllers')
	.controller('ManageClassController', ManageClassController);

ManageClassController.$inject = ['$scope', 'manageClassService', 'apiService', 'TableService', 'SearchService'];

function ManageClassController($scope, manageClassService, apiService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.add = {};
	self.fields = {};
	self.validation = {};

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		
		self.searchDefaults();
		self.add = {};
		self.fields = {};
		self.validation = {};

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_add_student = Constants.FALSE;

		switch(active) {
			case 'add_student' 			:
				self.success = Constants.FALSE;
				self.add_existing_student = Constants.FALSE;

				self.add.grade_code = self.record.grade.code;
				self.add.country_id = self.record.grade.country_id;

				self.active_add_student = Constants.TRUE;
				break; 

			case Constants.ACTIVE_VIEW	:
				self.details(id);
				self.studentList(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT	:
				self.success = Constants.FALSE;
				self.details(id);
				self.active_edit = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST	:
			default:
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.searchFnc = function() {
		self.list();
	}

	self.clear = function() {
		self.searchDefaults();
		self.list();
	}

	self.list = function() {
		if(self.active_list) {
			self.classList();
		} else if(self.active_view) {
			self.studentList(self.record.id);
		}
	}

	self.classList = function() {
		self.errors = Constants.FALSE;
		self.search.client_id = $scope.user.id;

		$scope.ui_block();
		manageClassService.list(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.record;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.studentList = function(id) {
		self.errors = Constants.FALSE;
		self.search.id = id;

		$scope.ui_block();
		manageClassService.studentList(self.search).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.students = response.data.record;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getGradeLevel = function() {
		self.grades = Constants.FALSE;
		var country_id = $scope.user.country_id;

		apiService.getGradeLevel(country_id).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.grades = response.data.records;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.details = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		manageClassService.details(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.record = response.data;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.update = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		manageClassService.update(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = TeacherConstant.UPDATE_CLASSNAME_SUCCESS;
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.addExistingStudent = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.add = {};
		self.add.email = self.record.email;
		self.add.client_id = self.record.client_id;
		self.add.class_id = self.record.id;

		$scope.ui_block();
		manageClassService.addExistingStudent(self.add).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					delete self.add;
					self.success = "You have successfully added a student to " + self.record.name;
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.validateUsername = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.validation.u_error = Constants.FALSE;
		self.validation.u_success = Constants.FALSE;
		self.validation.u_loading = Constants.TRUE;

		apiService.validateUsername(self.add.username, Constants.STUDENT).success(function(response) {
			self.validation.u_loading = Constants.FALSE;
			
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.validation.u_error = response.errors[0].message;

					if(angular.equals(self.validation.u_error, Constants.MSG_U_NOTEXIST)) {
						self.validation.u_error = Constants.FALSE;
						self.validation.u_success = Constants.TRUE;
					}
				} else if(response.data) {
					self.validation.u_error = Constants.MSG_U_EXIST;
				}
			}
		}).error(function(response) {
			self.validation.u_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});
	}

	self.validateEmail = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.validation.e_error = Constants.FALSE;
		self.validation.e_success = Constants.FALSE;
		self.validation.e_loading = Constants.TRUE;

		apiService.validateEmail(self.add.email, Constants.STUDENT).success(function(response) {
			self.validation.e_loading = Constants.FALSE;
			
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.validation.e_error = response.errors[0].message;

					if(angular.equals(self.validation.e_error, Constants.MSG_EA_NOTEXIST)) {
						self.validation.e_error = Constants.FALSE;
						self.validation.e_success = Constants.TRUE;
					}
				} else if(response.data) {
					self.validation.e_error = Constants.MSG_EA_EXIST;
				}
			}
		}).error(function(response) {
			self.validation.e_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});
	}

	self.addNewStudent = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = {};
		self.validation = {};

		self.add.client_id = self.record.client_id;
		self.add.class_id = self.record.id;
		// self.add.callback_uri
		// self.add.birth_date = 
		console.log(self.record);
		
		$scope.ui_block();
		manageClassService.addNewStudent(self.add).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					delete self.add;
					self.success = "You have successfully added a student to " + self.record.name;
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateBirthday = function() {

	}

	self.display = function() {

	}
}