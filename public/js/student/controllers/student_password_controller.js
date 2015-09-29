angular.module('futureed.controllers')
	.controller('StudentPasswordController', StudentPasswordController);

StudentPasswordController.$inject = ['$scope', 'StudentPasswordService'];

function StudentPasswordController($scope, StudentPasswordService) {
	var self = this;
	var user_type = Constants.STUDENT;
	
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
		self.student_id = id;
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

	self.sendResetCode = function(event) {
		event = getEvent(event);
		event.preventDefault();

		self.errors = Constants.FALSE;
		
		var base_url = $("#base_url_form input[name='base_url']").val();
		var forgot_password_url = base_url + Constants.URL_FORGOT_PASSWORD(angular.lowercase(user_type));

		$scope.ui_block();
		StudentPasswordService.forgotPassword(self.record.username, user_type, forgot_password_url).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.sent = Constants.TRUE;
					self.record.email = response.data.email;
				} 
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.resendResetCode = function() {
		self.errors = Constants.FALSE;

		var base_url = $("#base_url_form input[name='base_url']").val();
		var resend_code_url = base_url + Constants.URL_FORGOT_PASSWORD(angular.lowercase(user_type));

		$scope.ui_block();
		StudentPasswordService.resendResetCode(self.record.email, user_type, resend_code_url).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(self.errors, function(value) {
						if(angular.equals(value, "You have already setup the forgot password steps.")) {
							self.password_set = Constants.TRUE;
						}
					});
				} else if(response.data){
					self.resent = Constants.TRUE;
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
		StudentPasswordService.validateCode(self.record.reset_code, self.record.email, user_type).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
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

	self.selectNewPassword = function() {
		self.errors = Constants.FALSE;
		self.password_selected = Constants.FALSE;
		
		if($scope.image_id) {
			self.password_selected = Constants.TRUE;
			self.new_password = $scope.image_id;
			$scope.image_id = Constants.FALSE;

			$scope.image_pass = shuffle($scope.image_pass);
			$("ul.form_password li").removeClass('selected');
		} else {
			self.errors = [Constants.MSG_PPW_SELECT_NEW];
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.undoNewPassword = function() {
		self.errors = Constants.FALSE;
		$scope.image_pass = shuffle($scope.image_pass);
		self.password_selected = Constants.FALSE;
		$scope.$parent.image_id = self.new_password;

		$("ul.form_password li").removeClass("selected");
		$("input[value='" + self.new_password + "']").closest("li").addClass("selected");

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.saveNewPassword = function() {
		self.errors = Constants.FALSE;

		if(self.new_password == $scope.$parent.image_id) {
			$scope.ui_block();
			StudentPasswordService.setPassword(self.student_id, self.new_password).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else if(response.data) {
						self.password_isset = Constants.TRUE;
					} 
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		} else {
			self.errors = [Constants.MSG_PPW_NOT_MATCH];
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}
	}

	self.resetPassword = function() {
		self.errors = Constants.FALSE;

		if(self.new_password == $scope.$parent.image_id) {
			$scope.ui_block();
			StudentPasswordService.resetPassword(self.student_id, self.reset_code, self.new_password).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else if(response.data) {
						self.password_isset = Constants.TRUE;
					} 
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		} else {
			self.errors = [Constants.MSG_PPW_NOT_MATCH];
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}
	}
}