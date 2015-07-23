angular.module('futureed.controllers')
	.controller('ManageStudentController', ManageStudentController);

ManageStudentController.$inject = ['$scope', '$filter', 'manageStudentService', 'apiService',  'TableService', 'SearchService'];

function ManageStudentController($scope, $filter, manageStudentService, apiService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.delete = {};
	self.user_type = Constants.STUDENT;

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.fields = [];

		self.searchDefaults();
		self.tableDefaults();

		self.validation = {};

		self.active_list = Constants.FALSE;
		self.active_add  = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_EDIT 	:
				self.success = Constants.FALSE;
				self.active_edit = Constants.TRUE;
				self.viewStudent(id);
				break;

			case Constants.ACTIVE_VIEW 	:
				self.active_view = Constants.TRUE;
				self.viewStudent(id);
				break;
				
			case Constants.ACTIVE_ADD 	:
				self.record = {};
				self.success = Constants.FALSE;
				self.active_add = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST 	:
				self.active_list = Constants.TRUE;
				self.list();
				break;

			default 					:
				self.success = Constants.FALSE;
				self.active_list = Constants.TRUE;
				self.list();
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.searchFnc = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.tableDefaults();
		self.list();

		event = getEvent(event);
		event.preventDefault();
	}

	self.list = function() {
		if(self.active_list) {
			self.studentlist();
		}
	}

	self.clear = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.searchDefaults();
		self.tableDefaults();
		
		self.list();
	}

	self.studentlist = function() {
		self.errors = Constants.FALSE;
		self.records = {};
		self.table.loading = Constants.TRUE;
		
		$scope.ui_block();
		manageStudentService.getStudentlist(self.search, self.table).success(function(response){
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.records;
					self.updatePageCount(response.data);
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.checkUsernameAvailability = function(username) {
		self.errors = Constants.FALSE;
		self.validation.u_loading = Constants.TRUE;
		self.validation.u_error = Constants.FALSE;
		self.validation.u_success = Constants.FALSE;

		apiService.validateUsername(username, self.user_type).success(function(response) {
			self.validation.u_loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.validation.u_error = response.errors[0].message;
					
					if(angular.equals(self.validation.u_error, Constants.MSG_U_NOTEXIST)) {
						self.validation.u_error = Constants.FALSE;
						self.validation.u_success = Constants.MSG_U_AVAILABLE;
					}
				} else if(response.data) {
					if(self.record.id != response.data.id) {
						self.validation.u_error = Constants.MSG_U_EXIST;
					} else {
						self.validation.u_success = Constants.TRUE;
					}
				}
			}
		}).error(function(response) {
			self.validation.u_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});
	}

	self.checkEmailAvailability = function(email) {
		self.errors = Constants.FALSE;
		self.validation.e_loading = Constants.TRUE;
		self.validation.e_error = Constants.FALSE;
		self.validation.e_success = Constants.FALSE;

		apiService.validateEmail(email, self.user_type).success(function(response) {
			self.validation.e_loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.validation.e_error = response.errors[0].message;

					if(angular.equals(self.validation.e_error, Constants.MSG_EA_NOTEXIST)) {
						self.validation.e_error = Constants.FALSE;
						self.validation.e_success = Constants.TRUE;
					}
				} else if(response.data) {
					if(self.record.id != response.data.id) {
						self.validation.e_error = Constants.MSG_EA_EXIST;
					} else {
						self.validation.e_success = Constants.TRUE;
					}
				}
			}
		}).error(function(response) {
			self.validation.e_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});
	}

	self.searchSchool = function() {
		self.validation.s_loading = Constants.TRUE;
		self.validation.s_error = Constants.FALSE;
		self.schools = Constants.FALSE;

		manageStudentService.searchSchool(self.record.school_name).success(function(response) {
			self.validation.s_loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.validation.s_error = response.errors[0].message;
				} else if(response.data) {
					self.schools = [];

					angular.forEach(response.data, function(value, key) {
						self.schools[key] = value;
					});
				}
			} 
		}).error(function(response) {
			self.errors = $scope.internalError();
			self.validation.s_loading = Constants.FALSE;
		});
	}

	self.selectSchool = function(school) {
		self.schools = Constants.FALSE;
		self.validation = {};

		self.record.school_code = school.code;
		self.record.school_name = school.name;
	}

	self.getGradeLevel = function() {
		self.grades = Constants.FALSE;
		
		apiService.getGradeLevel(self.record.country_id).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.grades = response.data.records;
					self.country = Constants.TRUE;
				}
			}
		}).error(function(response) {
			$scope.internalError();
		});
	}
	
	self.save = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.validation = {};
		self.fields = [];

		var base_url = $("#base_url_form input[name='base_url']").val();
		self.record.callback_uri = self.base_url + Constants.URL_REGISTRATION(angular.lowercase(Constants.STUDENT));
		self.record.birth_date = $filter('date')(self.record.birth, 'yyyyMMdd');

		$scope.ui_block();
		manageStudentService.save(self.record).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
		            });
				} else if(response.data) {
					self.success = "Successfully added new student user.";
					self.record = {};
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.viewStudent = function(id){
		self.errors = Constants.FALSE;
		self.record = {};

		$scope.ui_block();
		manageStudentService.viewStudent(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var data = response.data;

					self.record = data;
					self.record.email = data.user.email;
					self.record.username = data.user.username;
					self.record.new_email = data.user.new_email;
					self.record.birth = data.birth_date;

					if(data.school) {
						self.record.school_name = data.school.name;
						self.record.school_code = data.school.code;
					}

					self.getGradeLevel();
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		})
	}

	/**
	*@return id
	*/
	self.saveEdit = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.validation = {};
		
		self.fields = [];
		self.record.birth_date = $filter('date')(self.record.birth, 'yyyyMMdd');

		$scope.ui_block();
		manageStudentService.saveEdit(self.record).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
		            });

				} else if(response.data) {
					self.success = "Successfully updated this student user.";
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.confirmDelete = function(id){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.delete.id = id;
		self.delete.confirm = Constants.TRUE;

		$("#delete_student_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.deleteStudent = function(){
		$scope.ui_block();
		manageStudentService.deleteStudent(self.delete.id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = 'Student ' + Constants.DELETE_SUCCESS;
					self.setActive(Constants.ACTIVE_LIST);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}