angular.module('futureed.controllers')
	.controller('ManageParentStudentController', ManageParentStudentController);

ManageParentStudentController.$inject = ['$scope', 'ManageParentStudentService', 'apiService', 'TableService', 'SearchService', 'ValidationService'];

function ManageParentStudentController($scope, ManageParentStudentService, apiService, TableService, SearchService, ValidationService) {
	var self = this;

	self.students = [{}];
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	ValidationService(self);
	self.default();

	self.validation = {};
	self.change = {};
	self.user_type = Constants.STUDENT;

	self.existActive = function() {
		self.reg = {};
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$('input, select').removeClass('required-field');
	}

	self.setActive = function(active, id, cond) {
		self.fields = [];
		self.errors = Constants.FALSE;
		self.cond = (cond) ? Constants.TRUE : Constants.FALSE;
		
		if(self.cond == 0){
			self.success = Constants.FALSE;
		}
		switch(active) {
			case Constants.ACTIVE_EDIT:
				self.active_list = Constants.FALSE;
				self.edit_form = Constants.TRUE;
				self.active_view = Constants.TRUE;
				self.edit = Constants.TRUE;
				self.success = Constants.FALSE;
				self.errors = Constants.FALSE;
				self.active_change = Constants.FALSE;
				self.viewStudent(id, self.cond);
				break;

			case 'change':
				self.validation = {};
				self.active_list = Constants.FALSE;
				self.active_view = Constants.FALSE;
				self.active_add = Constants.FALSE;
				self.active_invite = Constants.FALSE;
				self.exist = Constants.FALSE;
				self.active_change = Constants.TRUE;
				break;

			case Constants.ACTIVE_ADD:
				self.reg = {};
				self.active_list = Constants.FALSE;
				self.active_view = Constants.FALSE;
				self.active_add = Constants.TRUE;
				self.active_invite = Constants.FALSE;
				self.exist = Constants.TRUE;
				self.active_change = Constants.FALSE;
				break;

			case 'invite':
				self.active_list = Constants.FALSE;
				self.active_view = Constants.FALSE;
				self.active_add = Constants.FALSE;
				self.active_invite = Constants.TRUE;
				self.active_change = Constants.FALSE;
				break;

			case Constants.ACTIVE_VIEW:
				self.active_list = Constants.FALSE;
				self.active_add = Constants.FALSE;
				self.active_view = Constants.TRUE;
				self.edit_form = Constants.FALSE;
				self.edit = Constants.FALSE;
				self.active_change = Constants.FALSE;
				self.viewStudent(id,self.cond);
				break;

			case Constants.ACTIVE_LIST:
				self.exist = Constants.FALSE;
				self.active_list = Constants.TRUE;
				self.active_view = Constants.FALSE;
				self.active_add = Constants.FALSE;
				self.active_invite = Constants.FALSE;
				self.active_change = Constants.FALSE;
				break;
		}
		$('input, select').removeClass('required-field');
		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.searchFnc = function() {
		self.list();
		event = getEvent(event);
		event.preventDefault();
	}

	self.clear = function() {
		self.searchDefaults();
		self.list();
	}

	self.list = function() {
		if(self.active_list) {
			self.getStudentlist();
		} else if(self.active_view) {
			self.getStudent(self.record.id);
		}
	}

	self.getStudentlist = function() {
		self.errors = Constants.FALSE;
		self.students = Constants.FALSE;
		self.table.loading = Constants.TRUE;
		$scope.ui_block();
		var client_id = $scope.user.id;
		ManageParentStudentService.getStudentlist(client_id, self.search, self.table).success(function(response){

			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.students = response.data.records;
					self.updatePageCount(response.data);
					self.table.loading = Constants.FALSE;
				}
			}
		$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.addExist = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageParentStudentService.addExist(self.reg.email_exist, $scope.user.id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.setActive('invite');
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.submitCode = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();

		ManageParentStudentService.submitCode($scope.user.id, self.reg.invitation_code).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data) {
					self.success = Constants.STUDENT + ' ' + Constants.ADD_SUCCESS_MSG;
					self.setActive('list', 1);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		});
	}
	self.addStudent = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.reg.client_id = $scope.user.id;

		if(self.reg) {
				self.reg.birth_date = $("#add_student_form input[name='hidden_date']").val();
			}

		self.base_url = $("#base_url_form input[name='base_url']").val();
		self.reg.callback_uri = self.base_url + Constants.URL_REGISTRATION(angular.lowercase(Constants.STUDENT));
		$scope.ui_block();
		ManageParentStudentService.addStudent(self.reg).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						$("#add_student_form input[name='" + value.field +"']").addClass("required-field");
						$("#add_student_form select[name='" + value.field +"']").addClass("required-field");
		            });
				} else if(response.data) {
					self.success = Constants.TRUE;
					self.reg = {};
					self.validation = {};
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		});
		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.checkUsernameAvailability = function() {
		if(self.edit == 1) {

			self.validation = {};

		}
		self.errors = Constants.FALSE;
		self.validation.u_loading = Constants.TRUE;
		self.validation.u_error = Constants.FALSE;
		self.validation.u_success = Constants.FALSE;
		if(self.detail) {
			var username = (self.detail.username) ? self.detail.username : self.EMPTY_STR;
		} else {
			var username = (self.reg.username) ? self.reg.username : self.EMPTY_STR;
		}
		apiService.validateUsername(username, self.user_type).success(function(response) {
			self.validation.u_loading = Constants.FALSE;
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.validation.u_error = response.errors[0].message;
					if(angular.equals(self.validation.u_error, Constants.MSG_U_NOTEXIST)) {
						self.validation.u_error = Constants.FALSE;
						if(self.detail){
							self.validation.u_success = Constants.MSG_U_AVAILABLE;
						}else {
							self.validation.u_success = Constants.MSG_U_AVAILABLE;
						}
					}
				} else if(response.data) {
					if(self.reg.id != response.data.id) {
						self.validation.u_error = Constants.MSG_U_EXIST;
					} else {
						if(self.reg){
							self.validation.u_success = Constants.TRUE;
						}else {
							self.validation.u_success = Constants.MSG_U_AVAILABLE;
						}
						
					}
				}
			}
		}).error(function(response) {
			self.validation.u_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});
	}

	self.checkEmailAvailability = function() {
		if(self.active_change == 1){
			self.validation = {};
		}
		self.errors = Constants.FALSE;
		self.validation.e_loading = Constants.TRUE;
		self.validation.e_error = Constants.FALSE;
		self.validation.e_success = Constants.FALSE;

		if(self.change == 1) {
			var email = (self.change.new_email) ? self.change.new_email : self.EMPTY_STR;
		} else {
			var email = (self.reg.email) ? self.reg.email : self.EMPTY_STR;
		}

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
					if(self.reg.id != response.data.id) {
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

	self.viewStudent = function(id , cond) {
		self.errors = Constants.FALSE;
		self.validation = Constants.FALSE;
		if(cond == 0){
			self.success = Constants.FALSE;
		}
		self.detail = {};

		$scope.ui_block();

		ManageParentStudentService.viewStudent(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var data = response.data;
					self.detail = response.data;
					self.detail.email = data.user.email;
					self.detail.username = data.user.username;
					self.detail.new_email = data.user.new_email;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.saveStudent = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.validation = Constants.FALSE;

		self.detail.birth_date = $("#student_form input[name='hidden_date']").val();
		$scope.ui_block();
		ManageParentStudentService.saveStudent(self.detail).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						$("#student_form input[name='" + value.field +"']").addClass("required-field");
						$("#student_form select[name='" + value.field +"']").addClass("required-field");
		            });
				}else if(response.data) {
					self.success = Constants.TRUE;
					self.setActive('view', self.detail.id, 1);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		});

	}
	self.changeEmail = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		self.change.id = self.detail.id;
		self.change.client_id = $scope.user.id;
		self.change.email = self.change.current_email;
		var base_url = $("#base_url_form input[name='base_url']").val();
		self.change.callback_uri = base_url + Constants.URL_CHANGE_EMAIL(angular.lowercase(Constants.STUDENT));

		ManageParentStudentService.changeEmail(self.change).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.e_success = ParentConstant.UPDATE_STUDENT_EMAIL_SUCCESS;
					self.setActive('view', self.detail.id, 1);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		});
	}
}