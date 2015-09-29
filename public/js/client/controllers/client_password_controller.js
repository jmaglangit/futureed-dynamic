angular.module('futureed.controllers')
	.controller('ClientPasswordController', ClientPasswordController);

ClientPasswordController.$inject = ['$scope', 'ClientPasswordService'];

function ClientPasswordController($scope, ClientPasswordService) {
	var self = this;
	var user_type = Constants.CLIENT;

	self.record = {};

	self.checkForgotPasswordLink = function(email) {
		if(email) {
			self.setActive('linked');
			self.record.email = email;
		} else {
			self.setActive();
		}
	}

	self.setPasswordStatus = function(id, reset_code) {
		self.client_id = id;
		self.reset_code = (reset_code) ? reset_code : Constants.FALSE;
		self.password_isset = (self.password_isset) ? self.password_isset : Constants.FALSE;
	}

	self.setActive = function(active) {
		self.errors = Constants.FALSE;

		self.active_default = Constants.FALSE;
		self.active_linked = Constants.FALSE;

		switch(active) {
			case 'linked'	:
				self.active_linked = Constants.TRUE;
				break;

			default			:
				self.active_default = Constants.TRUE;
				break;
		}
	}

	self.clientForgotPassword = function(event) {
		event = getEvent(event);
		event.preventDefault();

		self.errors = Constants.FALSE;

		var base_url = $("#base_url_form input[name='base_url']").val();
		var forgot_password_url = base_url + Constants.URL_FORGOT_PASSWORD(angular.lowercase(user_type));

		$scope.ui_block();
		ClientPasswordService.forgotPassword(self.record.username, user_type, forgot_password_url).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.record.email = response.data.email;
					self.sent = Constants.TRUE;
				} 
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors =  $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.clientValidateCode = function(event) {
		event = getEvent(event);
		event.preventDefault();

		self.errors = Constants.FALSE;

		$scope.ui_block();
		ClientPasswordService.validateCode(self.record.reset_code, self.record.email, user_type).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					$("#redirect_form input[name='id']").val(response.data.id);
					$("#redirect_form input[name='reset_code']").val(self.record.reset_code);
					$("#redirect_form").submit();
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.clientResendCode = function() {
		self.errors = Constants.FALSE;
		
		var base_url = $("#base_url_form input[name='base_url']").val();
		var resend_code_url = base_url + Constants.URL_FORGOT_PASSWORD(angular.lowercase(user_type));

		$scope.ui_block();
		ClientPasswordService.resendResetCode(self.record.email, user_type, resend_code_url).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.resent = Constants.TRUE;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.resetClientPassword = function() {
		self.errors = Constants.FALSE;

		if(angular.equals(self.record.new_password, self.record.confirm_password)) {
			$scope.ui_block();
			ClientPasswordService.resetClientPassword(self.client_id, self.reset_code, self.record.new_password).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else if(response.data) {
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