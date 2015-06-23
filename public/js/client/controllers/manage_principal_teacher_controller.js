angular.module('futureed.controllers')
	.controller('ManagePrincipalTeacherController', ManagePrincipalTeacherController);

ManagePrincipalTeacherController.$inject = ['$scope', 'managePrincipalTeacherService', 'apiService'
	, 'TableService', 'SearchService'];

function ManagePrincipalTeacherController($scope, managePrincipalTeacherService, apiService, TableService, SearchService){

	var self = this;

	SearchService(self);
	self.searchDefaults();

	TableService(self);
	self.tableDefaults();

	self.records = {};
	self.record = {};

	self.validation = {};
	self.user_type = Constants.CLIENT;

	/**
	* Return Teacher List
	*/
	self.list = function() {
		if(self.active_list) {
			self.listRecords();
		} else if(self.active_view) {
			self.classDetails($scope.user.id);
		}
	}

	self.listRecords = function() {
		self.errors = Constants.FALSE;
		self.records = {};
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		managePrincipalTeacherService.list(self.search, self.table).success(function(response){
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
			self.table.loading = Constants.FALSE;
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.clear = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		
		self.tableDefaults();
		self.searchDefaults();
		
		self.list();
	}

	self.searchFnc = function(event) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.list();
		event = getEvent(event);
		event.preventDefault();
	}

	self.checkUsernameAvailability = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.validation.u_error = Constants.FALSE;
		self.validation.u_success = Constants.FALSE;
		self.validation.u_loading = Constants.TRUE;

		apiService.validateUsername(self.record.username, self.user_type).success(function(response) {
			self.validation.u_loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				self.fields['username'] = Constants.TRUE;

				if(response.errors){
					self.validation.u_error = response.errors[0].message;

					if(angular.equals(self.validation.u_error, Constants.MSG_U_NOTEXIST)){
						self.validation.u_error = Constants.FALSE;
						self.validation.u_success = Constants.TRUE;
						self.fields['username'] = Constants.FALSE;
					}
				}else if(response.data){
					self.validation.u_error = Constants.MSG_U_EXIST;
				}
			}
		}).error(function(response) {
			self.validation.u_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});
	}

	
	self.checkEmailAvailability = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.validation.e_error = Constants.FALSE;
		self.validation.e_success = Constants.FALSE;
		self.validation.e_loading = Constants.TRUE;

		apiService.validateEmail(self.record.email, self.user_type).success(function(response) {
			self.validation.e_loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)){
				self.fields['email'] = Constants.TRUE;

				if(response.errors){
					self.validation.e_error = response.errors[0].message;

					if(angular.equals(self.validation.e_error, Constants.MSG_EA_NOTEXIST)){
						self.validation.e_error = Constants.FALSE;
						self.validation.e_success = Constants.TRUE;
						self.fields['email'] = Constants.FALSE;
					}
				}else if(response.data){
					self.validation.e_error = Constants.MSG_EA_EXIST;
				}
			}
		}).error(function(response) {
			self.validation.e_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});
	}

	self.save = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.validation = {};
		self.fields = [];

		var base_url = $('input[name="base_url"]').val();
		self.record.callback_uri = base_url + '/client/registration';
		self.record.current_user = $scope.user.id;

		$scope.ui_block();
		managePrincipalTeacherService.save(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.record = {};
					self.success = TeacherConstant.ADD_TEACHER_SUCCESS;
				}
			}
			$scope.ui_unblock();
		}).error(function(response) {
			$scope.ui_unblock();
			self.internalError();
		});

	}

	self.details = function(id) {
		self.record = Constants.FALSE;

		$scope.ui_block();
		managePrincipalTeacherService.details(id).success(function(response) {

			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.record = response.data;
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.classDetails = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		managePrincipalTeacherService.classDetails(id, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.classes = response.data.record;
					self.updatePageCount(response.data);
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
		$("#update_teacher_form input").removeClass("required-field");

		$scope.ui_block();
		managePrincipalTeacherService.update(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						$("#update_teacher_form input[name='" + value.field +"']" ).addClass("required-field");
					});
				} else if(response.data){
					self.record = response.data;
					self.success = TeacherConstant.UPDATE_TEACHER_SUCCESS;

					self.active_edit = Constants.FALSE;
					self.active_view = Constants.TRUE;

					$("html, body").animate({ scrollTop: 0 }, "slow");
					self.details(response.data.id);
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.confirmDelete = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.delete_teacher = {};
		self.delete_teacher.id = id;
		self.delete_teacher.confirm = Constants.TRUE;
		
		$("#delete_teacher_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.delete = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		managePrincipalTeacherService.delete(self.delete_teacher.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = TeacherConstant.DELETE_TEACHER_SUCCESS;
					$("html, body").animate({ scrollTop: 0 }, "slow");
					self.list();
				}
 			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.setActive = function(page, id) {
		self.records = {};

		self.tableDefaults();
		self.searchDefaults();

		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.active_list = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_delete = Constants.FALSE;

		switch(page) {

			case 'add'	:
				self.record = {};
				self.fields = [];
				self.active_add = Constants.TRUE;
				break;

			case 'view'	:
				self.details(id);
				self.classDetails(id);
				self.active_view = Constants.TRUE;
				break;

			case 'edit'	:
				self.details(id);
				self.active_edit = Constants.TRUE;
				break;

			case 'delete':
				self.active_delete = Constants.TRUE
				break;

			case 'list' :
			default:
				self.active_list = Constants.TRUE;
				break
		}

		$('input, select').removeClass('required-field');
	    $("html, body").animate({ scrollTop: 0 }, "slow");			
	}
}