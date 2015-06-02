angular.module('futureed.controllers')
	.controller('ManageTeacherController', ManageTeacherController);

ManageTeacherController.$inject = ['$scope', 'manageTeacherService', 'apiService'
	, 'TableService', 'SearchService'];

function ManageTeacherController($scope, manageTeacherService, apiService, TableService, SearchService){

	var self = this;

	SearchService(self);
	self.searchDefaults();

	TableService(self);
	self.tableDefaults();


	self.validation = {};
	self.user_type = Constants.CLIENT;

	/**
	* Return Teacher List
	*/
	self.list = function() {
		self.errors = Constants.FALSE;
		self.records = {};
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		manageTeacherService.list(self.search, self.table).success(function(response){
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
		self.searchDefaults();
		self.list();
	}

	self.checkUsernameAvailability = function() {
		self.validation.e_error = Constants.FALSE;
		self.a_success = Constants.FALSE;
		self.a_loading = Constants.TRUE;
		

		var username = self.reg.username;e
		apiService.validateUsername(username, self.user_type).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.a_success = Constants.FALSE;
					self.a_loading = Constants.FALSE;
					self.val.a_error = response.errors[0].message;

					if(angular.equals(self.val.a_error, Constants.MSG_U_NOTEXIST)){
						self.val.a_error = Constants.FALSE;
						self.val.b_errors = Constants.FALSE;
						self.a_success = Constants.TRUE;
					}
				}else if(response.data){
					self.a_loading = Constants.FALSE;
					self.a_success = Constants.FALSE;
					self.val.a_error = Constants.MSG_U_EXIST;
				}
				$("html, body").animate({ scrollTop: 0 }, "slow");
			}
		}).error(function(response) {
			this.errors = $scope.internalError();
			this.a_loading = Constants.FALSE;
		});
	}

	
	self.checkEmailAvailability = function() {
		self.errors = Constants.FALSE;
		self.validation = {};
		self.validation.e_loading = Constants.TRUE;

		apiService.validateEmail(self.record.email, self.user_type).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.b_loading = Constants.FALSE;
					self.val.b_errors = response.errors[0].message;

					if(angular.equals(self.val.b_errors, Constants.MSG_EA_NOTEXIST)){
						self.val.b_errors = Constants.FALSE;
						self.val.a_error = Constants.FALSE;
						self.b_success = Constants.TRUE;
					}
				}else if(response.data){
					self.b_loading = Constants.FALSE;
					self.b_success = Constants.FALSE;
					self.val.b_errors = Constants.MSG_EA_EXIST;
				}
			}
		}).error(function(response) {
			self.b_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});
	}

	self.save = function() {
		self.errors = Constants.FALSE;

		var base_url = $('input[name="base_url"]').val();
		self.reg.callback_uri = base_url + '/client/register?email=' + self.reg.email;
		self.reg.current_user = $scope.user.id;

		$scope.ui_block();
		manageTeacherService.save(self.reg).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						$("#add_teacher_form input[name='" + value.field +"']" ).addClass("required-field");
					});

				}else if(response.data){
					self.errors = Constants.FALSE;
					self.is_success = Constants.Teacher + ' ' +  Constants.ADD_SUCCESS_MSG;
				}
			}
			$scope.ui_unblock();
		}).error(function(response) {
			$scope.ui_unblock();
			self.internalError();
		});

	}

	self.view = function(id){
		self.record = Constants.FALSE;

		$scope.ui_block();
		manageTeacherService.details(id).success(function(response) {

			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.record = response.data;
					self.setActive('view');
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.edit = function(id){
		self.record = Constants.FALSE;

		$scope.ui_block();
		manageTeacherService.details(id).success(function(response) {

			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.record = response.data;
					self.setActive('edit');
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.setActive = function(page) {
		self.record = {};
		self.records = {};

		self.active_list = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_delete = Constants.FALSE;

		switch(page) {

			case 'add'	:
				self.active_add = Constants.TRUE;
				break;

			case 'view'	:
				self.active_view = Constants.TRUE;
				break;

			case 'edit'	:
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