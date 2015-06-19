angular.module('futureed.controllers')
	.controller('ManageStudentController', ManageStudentController);

ManageStudentController.$inject = ['$scope', 'manageStudentService', 'apiService',  'TableService', 'SearchService'];

function ManageStudentController($scope, manageStudentService, apiService, TableService, SearchService) {
	var self = this;

	self.students = [{}];
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.getStudentlist = getStudentlist;
	self.user_type = Constants.STUDENT;

	self.setActive = function(active, id, fromEdit) {
		self.errors = Constants.FALSE;
		self.searchDefaults();
		self.validation = {};
		self.reg = {};

		self.fromEdit = (fromEdit) ? fromEdit:0;
		self.active_list = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_EDIT:
				self.active_view = Constants.TRUE;
				self.edit = Constants.TRUE;
				self.success = Constants.FALSE;
				self.errors = Constants.FALSE;
				self.edit = Constants.TRUE;
				self.viewStudent(id,self.fromEdit);
				break;
			case Constants.ACTIVE_VIEW:
				self.active_list = Constants.FALSE;
				self.active_add = Constants.FALSE;
				self.active_view = Constants.TRUE;
				self.edit = Constants.FALSE;
				self.viewStudent(id,self.fromEdit);
				break;
			case Constants.ACTIVE_ADD:
				self.active_add = Constants.TRUE;
				self.active_list = Constants.FALSE;
				self.active_view = Constants.FALSE;
				break;
			case Constants.ACTIVE_LIST:
			default:
				self.active_list = Constants.TRUE;
				self.active_add = Constants.FALSE;
				self.active_view = Constants.FALSE;
				break;
		}
		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	function getStudentlist() {
		self.errors = Constants.FALSE;
		self.students = Constants.FALSE;
		self.table.loading = Constants.TRUE;
		$scope.ui_block();

		manageStudentService.getStudentlist(self.search, self.table).success(function(response){

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

	self.checkUsernameAvailability = function() {
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
		self.errors = Constants.FALSE;
		self.validation.e_loading = Constants.TRUE;
		self.validation.e_error = Constants.FALSE;
		self.validation.e_success = Constants.FALSE;

		var email = (self.reg.email) ? self.reg.email : Constants.EMPTY_STR;

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

	self.searchSchool = function(method) {
		self.schools = Constants.FALSE;
		self.method = method;
		var school_name = '';

		switch(method){

			case 'edit':
				school_name = self.detail.school;
				self.detail.school_code = Constants.EMPTY_STR;
				break;

			case 'create':
			default:
				school_name = self.reg.school_name;
				self.reg.school_code = Constants.EMPTY_STR;
				break;
		}

		self.validation.s_loading = Constants.TRUE;
		self.validation.s_error = Constants.FALSE;
		manageStudentService.searchSchool(school_name).success(function(response) {
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
		var method = self.method;
		switch(method){
			case 'edit':
				self.detail.school_code = school.code;
				self.detail.school_name = school.name;
				break;

			case 'create':
			default:
				self.reg.school_code = school.code;
				self.reg.school_name = school.name;
				break;
		}

		self.schools = Constants.FALSE;
	}
	/**
	* Get Country ID
	*/
	self.getCountryId = function(){
		self.reg.countryid = Constants.EMPTY_STR;
		if(self.reg.countryid == Constants.EMPTY_STR) {
			self.country = Constants.TRUE;
		}
		else {
			self.country = Constants.FALSE;
		}
		self.reg.country_id = $('#country').find(':selected').data('id');
		self.getGradeLevel();
	}

	self.getGradeLevel = function() {
		self.grades = Constants.FALSE;
		
		if(self.detail){
			self.countryid = (self.detail.country_id != null) ? self.detail.country_id : 840;
		}else {	
			self.countryid = (self.reg.country_id != null) ? self.reg.country_id : 840;
		}
		apiService.getGradeLevel(self.countryid).success(function(response) {
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

		if(self.reg) {
				self.reg.birth_date = $("#add_student_form input[name='hidden_date']").val();
			}

		self.base_url = $("#base_url_form input[name='base_url']").val();
		self.reg.callback_uri = self.base_url + Constants.URL_REGISTRATION(angular.lowercase(Constants.STUDENT));
		$scope.ui_block();
		manageStudentService.save(self.reg).success(function(response){
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

	self.viewStudent = function(id, fromEdit){
		self.errors = Constants.FALSE;
		self.validation = Constants.FALSE;
		if(fromEdit == 0){
			self.success = Constants.FALSE;
		}
		self.detail = {};

		$scope.ui_block();

		manageStudentService.viewStudent(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var data = response.data;
					self.detail = response.data;
					self.detail.email = data.user.email;
					self.detail.username = data.user.username;
					self.detail.new_email = data.user.new_email;
					self.detail.school = data.school.name;
					self.getGradeLevel();
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.searchFnc = function() {
		self.list();
		event = getEvent(event);
		event.preventDefault();
	}

	self.list = function() {
		if(self.active_list) {
			self.getStudentlist();
		} else if(self.active_view) {
			self.getStudent(self.record.id);
		}
	}

	self.clear = function() {
		self.searchDefaults();
		self.list();
	}

	/**
	*@return id
	*/
	self.saveEdit = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.validation = Constants.FALSE;

		self.detail.birth_date = $("#view_student_form input[name='hidden_date']").val();

		$scope.ui_block();
		manageStudentService.saveEdit(self.detail).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						$("#add_student_form input[name='" + value.field +"']").addClass("required-field");
						$("#add_student_form select[name='" + value.field +"']").addClass("required-field");
		            });
				} else if(response.data) {
					self.success = Constants.TRUE;
					self.setActive('view', self.detail.id,1);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		})
	}
}