angular.module('futureed.controllers')
	.controller('ManageTeacherClassController', ManageTeacherClassController);

ManageTeacherClassController.$inject = ['$scope', '$filter', 'ManageClassService', 'apiService', 'TableService', 'SearchService'];

function ManageTeacherClassController($scope, $filter, ManageClassService, apiService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.add = {};
	self.fields = {};
	self.validation = {};

	self.setActive = function(active, id, flag) {
		self.errors = Constants.FALSE;
		
		self.searchDefaults();
		self.tableDefaults();
		self.add = {};
		self.fields = {};
		self.validation = {};

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_add_student = Constants.FALSE;

		if(flag != 1) {
			self.success = Constants.FALSE;
		}

		switch(active) {
			case 'add_student' 			:
				self.success = Constants.FALSE;
				self.add_existing_student = Constants.FALSE;
				
				self.setStudentData();
				self.fields = [];
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

	self.searchFnc = function(event) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.tableDefaults();
		self.list();

		event = getEvent(event);
		event.preventDefault();
	}

	self.clear = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.searchDefaults();
		self.tableDefaults();
		
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
		ManageClassService.list(self.search, self.table).success(function(response) {
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
		$scope.classid = id;
		self.errors = Constants.FALSE;
		self.search.id = id;
		$scope.ui_block();
		ManageClassService.studentList(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.students = response.data.records;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getGradeLevel = function(country_id) {
		self.grades = Constants.FALSE;

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
		ManageClassService.details(id).success(function(response) {
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
		ManageClassService.update(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
					self.success = TeacherConstant.UPDATE_CLASSNAME_SUCCESS;
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
		self.fields = [];

		self.add.client_id = self.record.client_id;
		self.add.class_id = self.record.id;

		$scope.ui_block();
		ManageClassService.addExistingStudent(self.add).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					delete self.add;

					self.success = "You have successfully added a student to " + self.record.name;
					self.setActive(Constants.ACTIVE_VIEW, self.record.id, 1);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});

		event = getEvent(event);
		event.preventDefault();
	}

	self.validateUsername = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.validation.u_error = Constants.FALSE;
		self.validation.u_success = Constants.FALSE;
		self.validation.u_loading = Constants.TRUE;
		self.fields['username'] = Constants.TRUE;

		apiService.validateUsername(self.add.username, Constants.STUDENT).success(function(response) {
			self.validation.u_loading = Constants.FALSE;
			
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.validation.u_error = response.errors[0].message;

					if(angular.equals(self.validation.u_error, Constants.MSG_U_NOTEXIST)) {
						self.validation.u_error = Constants.FALSE;
						self.validation.u_success = Constants.TRUE;
						self.fields['username'] = Constants.FALSE;
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
		self.fields['email'] = Constants.TRUE;

		apiService.validateEmail(self.add.email, Constants.STUDENT).success(function(response) {
			self.validation.e_loading = Constants.FALSE;
			
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.validation.e_error = response.errors[0].message;

					if(angular.equals(self.validation.e_error, Constants.MSG_EA_NOTEXIST)) {
						self.validation.e_error = Constants.FALSE;
						self.validation.e_success = Constants.TRUE;
						self.fields['email'] = Constants.FALSE;
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

		$("div.birth-date-wrapper select").removeClass("required-field");

		var birth_date = $("input#birth_date").val();
		self.add.birth_date = $filter(Constants.DATE)(new Date(birth_date), Constants.DATE_YYYYMMDD);
		
		var base_url = $("#base_url_form input[name='base_url']").val();
		self.add.callback_uri = base_url + "/student/registration";
		
		$scope.ui_block();
		ManageClassService.addNewStudent(self.add).success(function(response) {
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
					delete self.add;
					self.success = "You have successfully added a student to " + self.record.name;
					self.setActive(Constants.ACTIVE_VIEW, self.record.id, 1);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.clearData = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = [];
		self.validation = {};

		self.record.email = Constants.EMPTY_STR;

		self.add.username = Constants.EMPTY_STR;
		self.add.email = Constants.EMPTY_STR;
		self.add.first_name = Constants.EMPTY_STR;
		self.add.last_name = Constants.EMPTY_STR;
		self.add.gender = Constants.EMPTY_STR;
		self.add.city = Constants.EMPTY_STR;
		self.add.state = Constants.EMPTY_STR;
		self.add.birth = Constants.EMPTY_STR;
	}

	self.setDropdown = function(default_date) {
		var options = {
		      submitFieldName	: 'birth_date'
		    , wrapperClass	: 'birth-date-wrapper'
		    , minAge		: Constants.MIN_AGE
		    , maxAge		: Constants.MAX_AGE
		}

		if(default_date) {
			options.defaultDate = default_date;
		}

		$("#birth_date").dateDropdowns(options);
	}

	self.getSchoolDetails = function(school_code) {
		ManageClassService.getSchoolDetails(school_code).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var school = response.data;

					self.add.school_code = school.code;
					self.add.school_name = school.name;
					self.add.country = school.country;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.setStudentData = function() {
		self.add = {};
		
		self.add.grade_code = self.record.grade.code;
		self.add.country_id = self.record.grade.country_id;
		self.getSchoolDetails(self.record.client.school_code);
	}

	self.updateStudentStatus = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
	}

	self.display = function() {

	}

	self.setTabActive = function(active) {
		self.errors = Constants.FALSE;

		self.help_ans_tab_active = Constants.FALSE;
		self.help_tab_active = Constants.FALSE;
		self.tip_tab_active = Constants.FALSE;

		if(active) {
			self.success = Constants.FALSE;
		}

		switch(active) {
			case 'help-ans':
				self.help_ans_tab_active = Constants.TRUE;
				break;

			case 'help':
				self.help_tab_active = Constants.TRUE;
				break;

			case 'tip':
				self.tip_tab_active = Constants.TRUE;
				break;
			
			default:
				self.tip_tab_active = Constants.TRUE;
				break;
		}
	}


	self.confirmDeleteStudent = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		
		self.delete_student_id = id;
		self.delete_student_modal = Constants.TRUE;
		$("#delete_student_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });

		$("#delete_date").dateDropdowns({
		    submitFieldName: 'delete_date'
		});
	}

	self.deleteStudent = function(id) {
		self.delete_student = {};

		self.delete_student.errors = Constants.FALSE;
		self.delete_student.id = id;

		var day = $(".day").val();
		var month = $(".month").val();
		var year = $(".year").val();

		self.delete_student.date_removed = year + month + day;

		$scope.ui_block();
		ManageClassService.deleteStudent(self.delete_student).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.delete_student.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = Constants.DELETE_STU_SUCCESS;
					self.studentList($scope.classid);

					$('#delete_student_modal').modal('toggle');
				}
			}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.cancelDeleteStudent = function(){
		$(".day").prop("selectedIndex",0);
		$(".month").prop("selectedIndex",0);
		$(".year").prop("selectedIndex",0);
		self.delete_student = Constants.FALSE;
	}
}