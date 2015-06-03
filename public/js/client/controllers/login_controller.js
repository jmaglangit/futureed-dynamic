angular.module('futureed.controllers')
	.controller('LoginController', LoginController);

LoginController.$inject = ['$scope', 'apiService', 'clientLoginApiService', 'clientProfileApiService'];

function LoginController($scope, apiService, clientLoginApiService, clientProfileApiService) {
	var self = this;

	self.set = {};

	self.clientLogin = clientLogin;
	self.clientForgotPassword = clientForgotPassword;
	self.clientValidateCode = clientValidateCode;
	self.clientResendCode = clientResendCode;
	self.resetClientPassword = resetClientPassword;
	self.setNewClientPassword = setNewClientPassword;

	self.selectRole = selectRole;
	self.registerClient = registerClient;
	self.resendClientConfirmation = resendClientConfirmation;
	self.confirmClientRegistration = confirmClientRegistration;

	function clientLogin() {
	    $scope.errors = Constants.FALSE;
	    $scope.ui_block();
	    clientLoginApiService.clientLogin(self.username, self.password, self.role).success(function(response) {
	      if(response.status == Constants.STATUS_OK) {
	        if(response.errors) {
	          $scope.errorHandler(response.errors);
	          self.password = Constants.EMPTY_STR;
	        } else if(response.data) {
	          $("#login_form input[name='user_data']").val(angular.toJson(response.data));
	          $("#login_form").trigger(Constants.ATTR_SUBMIT);
	        }
	      }

	      $scope.ui_unblock();
	    }).error(function(response) {
	      $scope.ui_unblock();
	      $scope.internalError();
	      self.username = Constants.EMPTY_STR;
	      self.password = Constants.EMPTY_STR;
	      self.role = Constants.EMPTY_STR;
	    });
	}

	function clientForgotPassword() {
		$scope.$parent.errors = Constants.FALSE;
	    this.user_type = Constants.CLIENT;
	    this.base_url = $("#base_url_form input[name='base_url']").val();
	    this.forgot_password_url = this.base_url + Constants.URL_FORGOT_PASSWORD(angular.lowercase(this.user_type));

	    $scope.ui_block();
	    apiService.forgotPassword(this.username, this.user_type, this.forgot_password_url).success(function(response) {
	      if(response.status == Constants.STATUS_OK) {
	        if(response.errors) {
	          $scope.errorHandler(response.errors);
	        } else if(response.data){
	          $scope.email = response.data.email;
	          $scope.sent = Constants.TRUE;
	        } 
	      }

	      $scope.ui_unblock();
	    }).error(function(response) {
	      $scope.internalError();
	      $scope.ui_unblock();
	    });
	}

	function clientValidateCode(reset_code) {
		$scope.$parent.errors = Constants.FALSE;
	    $scope.reset_code = reset_code;
	    $scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("#redirect_form input[name='email']").val();
	    this.user_type = Constants.CLIENT;

	    $scope.ui_block();
	    apiService.validateCode($scope.reset_code, $scope.email, this.user_type).success(function(response) {
	      if(response.status == Constants.STATUS_OK) {
	        if(response.errors) {
	          $scope.errorHandler(response.errors);
	        } else if(response.data){
	          $("#redirect_form input[name='id']").val(response.data.id);
          	  $("#redirect_form input[name='reset_code']").val($scope.reset_code);
	          $("#redirect_form").submit();
	        } 
	      }

	      $scope.ui_unblock();
	    }).error(function(response) {
	      $scope.internalError();
	      $scope.ui_unblock();
	    });
	}

	function clientResendCode() {
	    $scope.$parent.errors = Constants.FALSE;
	    this.user_type = Constants.CLIENT;
	    $scope.email = (!isStringNullorEmpty($scope.email)) ? $scope.email : $("#redirect_form input[name='email']").val();
	    this.base_url = $("#base_url_form input[name='base_url']").val();
	    this.resend_code_url = this.base_url + Constants.URL_FORGOT_PASSWORD(angular.lowercase(this.user_type));

	    $scope.ui_block();
	    apiService.resendResetCode($scope.email, this.user_type, this.resend_code_url).success(function(response) {
	      if(response.status == Constants.STATUS_OK) {
	        if(response.errors) {
	          $scope.errorHandler(response.errors);
	        } else if(response.data){
	          $scope.resent = Constants.TRUE;
	        } 
	      }

	      $scope.ui_unblock();
	    }).error(function(response) {
	      $scope.internalError();
	      $scope.ui_unblock();
	    });
	}

	function resetClientPassword() {
	    $scope.$parent.errors = Constants.FALSE;

	    if(this.new_password == this.confirm_password) {
	      var reset_code = $("input[name='reset_code']").val();
	      var id = $("input[name='id']").val();

	      $scope.ui_block();
	      clientLoginApiService.resetClientPassword(id, reset_code, this.new_password).success(function(response) {
	        if(response.status == Constants.STATUS_OK) {
	          if(response.errors) {
	            $scope.errorHandler(response.errors);
	          } else if(response.data) {
	            $scope.$parent.success = Constants.TRUE;
	          }
	        }

	        $scope.ui_unblock();
	      }).error(function(response) {
	        $scope.internalError();
	        $scope.ui_unblock();
	      });
	    } else {
	      $scope.$parent.errors = [Constants.MSG_PW_NOT_MATCH];
	      $("html, body").animate({ scrollTop: 0 }, "slow");
	    }
	}

	function setNewClientPassword() {
	    $scope.$parent.errors = Constants.FALSE;

	    if(self.set.new_password == self.set.confirm_password) {
		    $scope.ui_block();
			clientLoginApiService.setClientPassword(self.set.id, self.set.new_password).success(function(response) {
				if(response.status == Constants.STATUS_OK) {
		          	if(response.errors) {
		            	$scope.errorHandler(response.errors);
		          	} else if(response.data) {
		            	self.set.success = Constants.TRUE;
		          	}
		        }

		        $scope.ui_unblock();
			}).error(function(response) {
				$scope.internalError();
		        $scope.ui_unblock();
			});
		} else {
			$scope.$parent.errors = [Constants.MSG_PW_NOT_MATCH];
	      	$("html, body").animate({ scrollTop: 0 }, "slow");
		}
	}

	function selectRole(role) {
	    this.principal = Constants.FALSE;
	    this.teacher = Constants.FALSE;
	    this.parent = Constants.FALSE;
	    this.reg = (this.reg) ? this.reg: {} ;

	    switch(role) {
	      case Constants.PRINCIPAL :
	        this.required = Constants.FALSE;
	        this.role_click = Constants.TRUE;
	        this.principal = Constants.TRUE;
	        this.reg.client_role = Constants.PRINCIPAL;
	        break;

	      case Constants.PARENT    :
	      	this.required = Constants.TRUE;
	        this.role_click = Constants.TRUE;
	        this.parent = Constants.TRUE;
	        this.reg.client_role = Constants.PARENT;
	        break;

	      default:
	      	this.reg = {};
	        break;
	    }
	}

	function registerClient() {
	    $scope.$parent.errors = Constants.FALSE;

	    $("#registration_form input").removeClass("required-field");
	    $("#registration_form select").removeClass("required-field");
	    
	    if($scope.e_error || $scope.u_error) {
	      $("html, body").animate({ scrollTop: 320 }, "slow");
	    } else if(!this.term) {
	      $scope.$parent.errors = ["Please accept the terms and conditions."];
	      $("html, body").animate({ scrollTop: 0 }, "slow");
	    } else if(this.reg.password != this.reg.confirm_password) {
	      $("#registration_form input[name='password']").addClass("required-field");
	      $("#registration_form input[name='confirm_password']").addClass("required-field");
	      $scope.$parent.errors = [Constants.MSG_PW_NOT_MATCH];
	      $("html, body").animate({ scrollTop: 0 }, "slow");
	    } else {
	      $scope.ui_block();
	      this.email = this.reg.email;
	      this.base_url = $("#base_url_form input[name='base_url']").val();
	      this.reg.callback_uri = this.base_url + Constants.URL_REGISTRATION(angular.lowercase(Constants.CLIENT));

	      clientLoginApiService.registerClient(this.reg).success(function(response) {
	        if(response.status == Constants.STATUS_OK) {
	          if(response.errors) {
	            $scope.errorHandler(response.errors);

	            angular.forEach(response.errors, function(value, key) {
	              $("#registration_form input[name='" + value.field +"']").addClass("required-field");
	              $("#registration_form select[name='" + value.field +"']").addClass("required-field");
	            });
	          } else if(response.data) {
	            $scope.$parent.registered = Constants.TRUE;
	          }
	        }
	        $scope.ui_unblock();
	      }).error(function(response) {
	        $scope.internalError();
	        $scope.ui_unblock();
	      });
	    }
	  }

	function resendClientConfirmation() {
	    $scope.$parent.errors = Constants.FALSE;

	    self.user_type = Constants.CLIENT;
	    self.email = (!isStringNullorEmpty(self.email)) ? self.email : $("#registration_success_form input[name='email']").val();
	    this.base_url = $("#base_url_form input[name='base_url']").val();
	    this.resend_confirmation_url = this.base_url + Constants.URL_REGISTRATION(angular.lowercase(this.user_type));

	    $scope.ui_block();
	    apiService.resendConfirmation(self.email, self.user_type, this.resend_confirmation_url).success(function(response) {
	      if(response.status == Constants.STATUS_OK) {
	        if(response.errors) {
	          $scope.errorHandler(response.errors);

	          angular.forEach($scope.errors, function(value, key) {
	          	if(angular.equals(value, Constants.MSG_ACC_CONFIRMED)) {
	          		self.account_confirmed = Constants.TRUE;
	          	}
	          });
	        } else if(response.data) {
	          self.resent = Constants.TRUE;
	        }
	      }
	      $scope.ui_unblock();
	    }).error(function(response) {
	      $scope.internalError();
	      $scope.ui_unblock();
	    });
	}

  	function confirmClientRegistration() {
  		$scope.$parent.errors = Constants.FALSE;
	    
	    self.user_type = Constants.CLIENT;
	    self.email = (!isStringNullorEmpty(self.email)) ? self.email : $("#registration_success_form input[name='email']").val();

	    $scope.ui_block();
	    apiService.confirmCode(self.email, self.confirmation_code, self.user_type).success(function(response) {
	      if(response.status == Constants.STATUS_OK) {
	        if(response.errors) {
	          $scope.errorHandler(response.errors);
	        } else if(response.data){
	          self.confirmed = Constants.TRUE;
	          self.set.id = response.data.id;
	          console.log(self.set);
	        } 
	      }

	      $scope.ui_unblock();
	    }).error(function(response) {
	      $scope.internalError();
	      $scope.ui_unblock();
	    });
	}
}	