angular.module('futureed.controllers')
	.controller('ManageAdminController', ManageAdminController);

ManageAdminController.$inject = ['$scope', 'ManageAdminService', 'apiService', 'TableService', 'SearchService'];

function ManageAdminController($scope, ManageAdminService, apiService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults()

	self.user_type = Constants.ADMIN;
	this.reg = {};
	this.val = {};
	self.validation = {};
	self.change = {};
	self.delete = {};

	self.deleteModeAdmin = deleteModeAdmin;
	this.saveAdmin = saveAdmin;
	this.checkUsernameAvailability = checkUsernameAvailability;
	this.checkEmailAvailability = checkEmailAvailability;

	this.editAdmin = editAdmin;
	this.resetPass = resetPass;

	self.validateNewAdminEmail = validateNewAdminEmail;
	self.confirmNewEmail = confirmNewEmail;
	self.changeAdminEmail = changeAdminEmail;
	self.confirmDelete = confirmDelete;

	self.setActive = function(active, id){
		self.errors = Constants.FALSE;
		self.reset_success = Constants.FALSE;
		self.update_success = Constants.FALSE;
		self.validation = {};
		self.change = {};
		self.reg = {};

		self.active_list_admin = Constants.FALSE;
		self.active_add_admin  = Constants.FALSE
		self.active_view_admin = Constants.FALSE;
		self.active_edit_admin = Constants.FALSE;
		self.active_edit_email = Constants.FALSE;
		self.active_edit_pass  = Constants.FALSE;

		switch(active){
			case 'pass' :
				// TODO: create an object for this
				self.password = Constants.EMPTY_STR;
				self.password_c = Constants.EMPTY_STR;
				self.active_edit_pass = Constants.TRUE;
				break;

			case Constants.ACTIVE_ADD :
				self.active_add_admin = Constants.TRUE;
				break;

			case Constants.ACTIVE_VIEW :
				self.viewAdmin(id);
				self.active_view_admin = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT :
				self.viewAdmin(id);
				self.active_edit_admin = Constants.TRUE;
				break;

			case 'edit_email' :
				self.active_edit_email = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST :
			default:
				self.getAdminList();
				self.active_list_admin = Constants.TRUE;
				break;
		} 

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.getAdminList = function(){
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageAdminService.getAdminList(self.search, self.table).success(function(response){
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.data = response.data.records;
					self.updateTable(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.table.loading = Constants.FALSE;
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.clearSearch = function(){
		self.errors = Constants.FALSE;

		self.searchDefaults();
		self.tableDefaults();

		self.getAdminList();
	}

	function saveAdmin(){
		self.errors = Constants.FALSE;
		self.reg.success = Constants.FALSE;
		self.validation = {};
		
		if(!angular.equals(self.reg.password, self.reg.confirm_password)){
			self.errors = [Constants.MSG_PW_NOT_MATCH];
			$("html, body").animate({ scrollTop: 0 }, "slow");
		} else {	
			$("input, select").removeClass("required-field");

			$scope.ui_block();
			ManageAdminService.saveAdmin(self.reg).success(function(response){
				if(angular.equals(response.status, Constants.STATUS_OK)){
					if(response.errors){
						self.errors = $scope.errorHandler(response.errors);

						angular.forEach(response.errors, function(value, key){
							$("#add_admin_form input[name='" + value.field +"']" ).addClass("required-field");
							$("#add_admin_form select[name='" + value.field +"']" ).addClass("required-field");
						});

					}else if(response.data){
						self.reg = {};
						self.reg.success = Constants.TRUE;
						$("html, body").animate({ scrollTop: 0 }, "slow");
					}
				}
				$scope.ui_unblock();
			}).error(function(response){
				$scope.ui_unblock();
				self.errors = $scope.internalError();
			});
		}
	}

	self.viewAdmin = function(id){
		self.errors = Constants.FALSE;
		self.is_success = Constants.FALSE;

		$scope.ui_block();
		ManageAdminService.viewAdmin(id).success(function(response) {
			if(angular.equals(response.status,Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.record = response.data;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function checkUsernameAvailability(username){
		self.validation.u_error = Constants.FALSE;
		self.validation.u_success = Constants.FALSE;
		self.validation.u_loading = Constants.TRUE;

		apiService.validateUsername(username, self.user_type).success(function(response){
			self.validation.u_loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.validation.u_error = response.errors[0].message;

					if(angular.equals(self.validation.u_error, Constants.MSG_U_NOTEXIST)){
						self.validation.u_error = Constants.FALSE;
						// in registration
						self.validation.u_success = Constants.TRUE;
					}
				}else if(response.data){
					// in profile
					if(self.admininfo && response.data.id == self.admininfo.id) {
						self.validation.u_success = Constants.TRUE;
					} else {
						self.validation.u_error = Constants.MSG_U_EXIST;
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			self.validation.u_loading = Constants.FALSE;
		});
	}

	
	function checkEmailAvailability(email){
		self.validation.e_error = Constants.FALSE;
		self.validation.e_success = Constants.FALSE;
		self.validation.e_loading = Constants.TRUE;

		apiService.validateEmail(email, self.user_type).success(function(response){
			self.validation.e_loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.validation.e_error = response.errors[0].message;

					if(angular.equals(self.validation.e_error, Constants.MSG_EA_NOTEXIST)){
						self.validation.e_error = Constants.FALSE;
						// in registration
						self.validation.e_success = Constants.TRUE;
					}
				}else if(response.data){
					self.validation.e_error = Constants.MSG_EA_EXIST;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			self.validation.e_loading = Constants.FALSE;
		});
	}

	function editAdmin() {
		self.errors = Constants.FALSE;
		self.record.email = self.record.user.email;
		self.record.username = self.record.user.username;


		$scope.ui_block();
		ManageAdminService.editAdmin(self.admininfo).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key){
						$("#add_admin_form input[name='" + value.field +"']" ).addClass("required-field");
					});

				}else if(response.data){
					self.update_success = Constants.TRUE;
					self.viewAdmin(response.data.id);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.ui_unblock();
			self.errors = $scope.internalError();
		});

	}

	function resetPass(){
		self.errors = Constants.FALSE;

		if(self.password != self.password_c){
			self.errors = [Constants.MSG_PW_NOT_MATCH];
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}else{
			$scope.ui_block();
			ManageAdminService.resetPass(self.password, self.admininfo.id).success(function(response){
				if(angular.equals(response.status, Constants.STATUS_OK)){
					if(response.errors){
						self.errors = $scope.errorHandler(response.errors);
					}else if(response.data){
						self.reset_success = Constants.TRUE;
					}
				}
				
				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			})
		}
	}

	function validateNewAdminEmail() {
		self.errors = Constants.FALSE;
		// Clear error messages in new email field
		self.validation.n_error = Constants.FALSE;
		self.validation.n_success = Constants.FALSE;
		self.validation.n_loading = Constants.TRUE;

		// Clear error messages in confirm email field
		self.validation.c_error = Constants.FALSE;
		self.validation.c_success = Constants.FALSE;

		ManageAdminService.checkAdminEmail(self.admininfo.id, self.change.new_email).success(function(response) {
			
			self.validation.n_loading = Constants.FALSE;
			
			if(angular.equals(response.status, Constants.STATUS_OK)) {
		        if(response.errors) {
		            self.validation.n_error = response.errors[0].message;
		        } else if(response.data) {
		        	self.validation.n_success = Constants.TRUE;
		        	self.validation.c_error = Constants.MSG_EA_CONFIRM;
		        }
		    }
			
		}).error(function(response) {
			self.validation.n_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});

	}

	function confirmNewEmail() {
		self.errors = Constants.FALSE;
		self.validation.c_error = Constants.FALSE;
		self.validation.c_success = Constants.FALSE;
		
		if(!angular.equals(self.change.new_email, self.change.confirm_email)) {
			self.validation.c_error = Constants.MSG_EA_NOT_MATCH;
		} else {
			self.validation.c_success = Constants.TRUE;
		}
	}
	function confirmDelete(id){
		self.errors = Constants.FALSE;
		self.delete.id = id;
		self.delete.confirm = Constants.TRUE;
		$("#delete_admin_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	function deleteModeAdmin(){
		self.errors = Constants.FALSE;
		self.validation.c_error = Constants.FALSE;
		self.validation.c_success = Constants.FALSE;

		$scope.ui_block();
		ManageAdminService.deleteModeAdmin(self.delete.id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.validation.c_success = 'User ' + Constants.DELETE_SUCCESS;
					self.getAdminList();
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	function changeAdminEmail() {
		self.errors = Constants.FALSE;

		self.base_url = $("#base_url_form input[name='base_url']").val();
	    var callback_uri = self.base_url + "/" + angular.lowercase(Constants.ADMIN);

		$scope.ui_block();
		ManageAdminService.changeAdminEmail(self.admininfo.id, self.change.new_email, callback_uri).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.admininfo.user.email = self.change.new_email;
					self.change.success = Constants.TRUE;
					self.setActive('view');
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.paginateBySize = function() {
		self.table.page = 1;
		self.table.offset = (self.table.page - 1) * self.table.size;
		self.getAdminList();
	}

	self.paginateByPage = function() {
		var page = self.table.page;
		
		self.table.page = (page < 1) ? 1 : page;
		self.table.offset = (page - 1) * self.table.size;

		self.getAdminList();
	}

	self.updateTable = function(data) {
		self.table.total_items = data.total;

		// Set Page Count
		var page_count = data.total / self.table.size;
			page_count = (page_count < Constants.DEFAULT_PAGE) ? Constants.DEFAULT_PAGE : Math.ceil(page_count);
		self.table.page_count = page_count;
	}
}