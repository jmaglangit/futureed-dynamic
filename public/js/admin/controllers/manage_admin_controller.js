angular.module('futureed.controllers')
	.controller('ManageAdminController', ManageAdminController);

ManageAdminController.$inject = ['$scope', 'manageAdminService', 'apiService'];

function ManageAdminController($scope, manageAdminService, apiService) {
	
	var self = this;

	this.reg = {};
	this.val = {};

	this.getAdminList = getAdminList;
	this.addAdmin = addAdmin;
	this.viewAdmin = viewAdmin;
	this.saveAdmin = saveAdmin;
	this.checkUsernameAvailability = checkUsernameAvailability;
	this.checkEmailAvailability = checkEmailAvailability;
	this.editAdmin = editAdmin;
	this.setActive = setActive;
	this.resetPass = resetPass;

	function getAdminList(){

		manageAdminService.getAdminList().success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data){
					self.data = response.data.records;
				}
			}
		}).error(function(response) {
			this.internalError();
		});
	}

	function addAdmin(){
		self.add_admin = Constants.TRUE;
	}

	function saveAdmin(){
		self.errors = Constants.FALSE;

		self.reg.status = $('input[name=status]:checked', '#add_admin_form').val();

		if(self.val.a_error == Constants.FALSE && self.val.b_errors == Constants.FALSE){
			if(self.reg.password != self.reg.password_c){
				self.p_error = Constants.MSG_PW_NOT_MATCH;
			}else{
				$scope.ui_block();
				manageAdminService.saveAdmin(self.reg).success(function(response){
					if(angular.equals(response.status, Constants.STATUS_OK)){
						if(response.errors){
							self.errors = $scope.errorHandler(response.errors);

							angular.forEach(response.errors, function(value, key){
								$("#add_admin_form input[name='" + value.field +"']" ).addClass("required-field");
							});

						}else if(response.data){
							self.errors = Constants.FALSE;
							self.is_success = 'User ' + Constants.ADD_SUCCESS_MSG;
							self.add_admin = Constants.FALSE;

						}
					}
					$scope.ui_unblock();
				}).error(function(response){
					$scope.ui_unblock();
					self.errors = $scope.internalError();
				});
			}
		}
		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	function viewAdmin(id){
		self.is_success = Constants.FALSE;
		self.errors = Constants.FALSE;
		self.view_admin = Constants.TRUE;

		manageAdminService.viewAdmin(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.data){
					self.admininfo = response.data;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	function checkUsernameAvailability(){
		self.val.a_error = Constants.FALSE;
		self.a_success = Constants.FALSE;
		self.a_loading = Constants.TRUE;
		self.user_type = Constants.ADMIN;

		var username = (self.reg.username) ? self.reg.username : self.admininfo.user.username;

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

	
	function checkEmailAvailability(){
		self.val.b_errors = Constants.FALSE;
		self.b_success = Constants.FALSE;
		self.user_type = Constants.ADMIN;
		self.b_loading = Constants.TRUE;

		var email = (self.reg.email) ? self.reg.email : self.admininfo.user.email;

		apiService.validateEmail(email, self.user_type).success(function(response){
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

	function editAdmin(){
		self.errors = Constants.FALSE;
		self.admininfo.email = self.admininfo.user.email;
		self.admininfo.username = self.admininfo.user.username;

		self.admininfo.status = $('input[name=status]:checked', '#add_admin_form').val();
		if(self.val.a_error == Constants.FALSE && self.val.b_errors == Constants.FALSE){
			$scope.ui_block();
				manageAdminService.editAdmin(self.admininfo).success(function(response){
					if(angular.equals(response.status, Constants.STATUS_OK)){
						if(response.errors){
							self.errors = $scope.errorHandler(response.errors);

							angular.forEach(response.errors, function(value, key){
								$("#add_admin_form input[name='" + value.field +"']" ).addClass("required-field");
							});

						}else if(response.data){
							self.errors = Constants.FALSE;
							self.is_success = 'User ' + Constants.EDIT_SUCCESS;
							self.add_admin = Constants.FALSE;
							self.edit = Constants.FALSE;

						}
					}
					$scope.ui_unblock();
				}).error(function(response){
					$scope.ui_unblock();
					self.errors = $scope.internalError();
				});
		}

	}

	function resetPass(){
		self.errors = Constants.FALSE;
		self.r_error = Constants.FALSE;

		if(self.password != self.password_c){
			self.r_error = Constants.MSG_PW_NOT_MATCH;
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}else{
			$scope.ui_block();
			console.log(self.password)
			manageAdminService.resetPass(self.password, self.admininfo.id).success(function(response){
				if(angular.equals(response.status, Constants.STATUS_OK)){
					if(response.errors){
						self.errors = $scope.errorHandler(response.errors);
					}else if(response.data){
						self.reset_success = Constants.TRUE;
					}
				}
				$scope.ui_unblock();
			}).error(function(response){
				$scope.ui_unblock();
				self.errors = $scope.internalError();
			})
		}
	}

	function setActive(name){
		
		switch(name){
			case 'pass' :
				self.reset_pass = Constants.TRUE;
				self.veiw_admin = Constants.FALSE;
				self.add_admin  = Constants.FALSE;
				break;

			case 'edit' :
				self.edit = Constants.TRUE;
				break;

			case 'view' :
			default:
				self.edit = Constants.FALSE;
				break;
		} 
	}
}