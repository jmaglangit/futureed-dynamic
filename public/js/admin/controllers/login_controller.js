angular.module('futureed')
	.controller('AdminLoginController', AdminLoginController);

AdminLoginController.$inject = ['$scope', 'AdminLoginApiService'];

function AdminLoginController($scope, AdminLoginApiService){
	var self = this;
	var user_type = Constants.ADMIN;
	
	self.record = {};

	self.init = function(forgot_password_url, email) {
		self.forgot_password_url = forgot_password_url;
		
		if(email) {
			self.record.email = email;
		}
	}

	self.initPasswordStatus = function(id, reset_code) {
		self.admin_id = id;
		self.reset_code = (reset_code) ? reset_code : Constants.FALSE;
	}

	self.validateAdmin = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		localStorage.authorization = 0;
		AdminLoginApiService.adminDoLogin(self.username, self.password).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					self.password = Constants.EMPTY_STR;
				}else if(response.data) {
					$("#login_form input[name='user_data']").val(angular.toJson(response.data));
					$("#login_form").trigger(Constants.ATTR_SUBMIT);
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.forgotPassword = function(event){
		event = getEvent(event);
		event.preventDefault();

		self.errors = Constants.FALSE;

		$scope.ui_block();
		AdminLoginApiService.forgotPassword(self.username, user_type, self.forgot_password_url).success(function(response) {
		  	if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data) {
			  		self.record.email = response.data.email;
			  		self.sent = Constants.TRUE;
				} 
		  	}

		  	$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
		  	$scope.ui_unblock();
		});
	}

	self.validateCode = function(event) {
		event = getEvent(event);
		event.preventDefault();

		self.errors = Constants.FALSE;

		$scope.ui_block();
		AdminLoginApiService.validateCode(self.record.reset_code, self.record.email, user_type).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data) {
					$("#redirect_form input[name='id']").val(response.data.id);
					$("#redirect_form input[name='reset_code']").val(self.record.reset_code);
					$("#redirect_form").submit();
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})

	}

	self.resendCode = function(){
		self.errors = Constants.FALSE;
	
		$scope.ui_block();
		AdminLoginApiService.resendResetCode(self.record.email, user_type, self.forgot_password_url).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data) {
				  	self.resent = Constants.TRUE;
				} 
			}
		  	
		  	$scope.ui_unblock();
		}).error(function(){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.resetPassword = function(){		
		self.errors = Constants.FALSE;

		if(angular.equals(self.new_password, self.confirm_password)) {
			$scope.ui_block();
			AdminLoginApiService.resetPassword(self.admin_id, self.reset_code, self.new_password).success(function(response){
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					}else if(response.data) {
						self.success = Constants.TRUE;
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		} else {
			self.errors = [Constants.MSG_PW_NOT_MATCH];
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}
	}
}