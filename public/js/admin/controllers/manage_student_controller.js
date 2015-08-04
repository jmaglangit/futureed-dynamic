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

	self.setActive = function(active, id, flag) {
		self.errors = Constants.FALSE;
		self.fields = [];

		self.searchDefaults();
		self.tableDefaults();

		self.validation = {};

		self.active_list = Constants.FALSE;
		self.active_add  = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_reward = Constants.FALSE;
		self.active_edit_reward = Constants.FALSE;
		self.active_points = Constants.FALSE;
		self.active_badge = Constants.FALSE;

		if(flag == 'points'){
			self.active_points = Constants.TRUE;
		}else{
			self.active_badge = Constants.TRUE;
		}

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

			case 'reward' :
				self.active_reward = Constants.TRUE;
				self.getPoints(id);
				self.getBadges(id);
				break;

			case 'edit_reward' :
				self.success = Constants.FALSE;
				self.active_edit_reward = Constants.TRUE;
					if(flag == 'points'){
						self.getPointDetail(id)
					}else{
						self.getBadgeDetail(id);
					}
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
					self.record.id = data.id;

					self.moduleList(id);

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

	self.moduleList = function(id) {
		manageStudentService.moduleList(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.modules = response.data.records;
					angular.forEach(self.modules, function(value,key){
						value.student_module_id = value.student_module[0].id;
					});

					self.updatePageCount(response.data);
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.resetModule = function(id, student_id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();

		manageStudentService.resetModule(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = Constants.RESET_SUCCESS;

					self.moduleList(student_id);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getPoints = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();

		manageStudentService.getPoints(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.points = response.data.records
					self.updatePageCount(response.data);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getBadges = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();

		manageStudentService.getBadges(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.badges = response.data.records
					self.updatePageCount(response.data);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getPointDetail = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();

		manageStudentService.getPointDetail(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.point_detail = {};

					var point = response.data;

					self.point_detail.points_earned = point.points_earned;
					self.point_detail.event = point.event.name;
					self.point_detail.description = point.event.description;
					self.point_detail.event_id = point.event.id;
					self.point_detail.date_earned = point.earned_at;
					self.point_detail.id = point.id;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getEvents = function(event) {
		self.s_error = Constants.FALSE;
		self.success = Constants.FALSE;
		self.s_loading = Constants.TRUE;

		manageStudentService.getEvents(event).success(function(response){
			self.s_loading = Constants.FALSE;
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.events = response.data.records;

					if(self.events.length == Constants.FALSE) {
						self.events = Constants.FALSE;
						self.s_error = Constants.MSG_NO_RECORD;
					}
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		})
	}

	self.selectEvent = function(event){
		self.point_detail.event = event.name;
		self.point_detail.event_id = event.id;

		self.events = Constants.FALSE;
	}

	self.savePoint = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();

		manageStudentService.savePoint(self.point_detail).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = Constants.POINT_UPDATE;
					self.setActive('reward', self.record.id);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getBadgeDetail = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();

		manageStudentService.getBadgeDetail(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.badge_detail = {};

					var badge = response.data;

					self.badge_detail.badge_id = badge.badge_id;
					self.badge_detail.date_earned = badge.created_at;
					self.badge_detail.name = badge.badges.name;
					self.badge_detail.id = badge.id;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getAllBadges = function(name) {
		self.s_error = Constants.FALSE;
		self.success = Constants.FALSE;
		self.s_loading = Constants.TRUE;

		manageStudentService.getAllBadges(name).success(function(response){
			self.s_loading = Constants.FALSE;
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.list_badges = response.data.records;

					if(self.list_badges.length == Constants.FALSE) {
						self.list_badges = Constants.FALSE;
						self.s_error = Constants.MSG_NO_RECORD;
					}
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		})
	}

	self.selectBadge = function(badge) {
		self.badge_detail.name = badge.name;
		self.badge_detail.badge_id = badge.id;

		self.list_badges = Constants.FALSE;
	}

	self.saveBadge = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();

		manageStudentService.saveBadge(self.badge_detail).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = Constants.BADGE_UPDATE;
					self.setActive('reward', self.record.id);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.confirmBadgeDelete = function(id){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.delete.id = id;
		self.delete.confirm_badge = Constants.TRUE;

		$("#delete_badge_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.deleteBadge = function(){
		$scope.ui_block();
		manageStudentService.deleteBadge(self.delete.id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = Constants.BADGE_DELETE;
					self.setActive('reward', self.record.id);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}