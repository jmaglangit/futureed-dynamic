angular.module('futureed.controllers')
	.controller('LoginController', LoginController);

LoginController.$inject = ['$scope', 'apiService', 'clientLoginApiService', 'clientProfileApiService'];

function LoginController($scope, apiService, clientLoginApiService, clientProfileApiService) {
	var self = this;

	self.set = {};
	self.validation = {};

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
	          	var data = response.data;
	          	  	data.role = self.role;
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
	    self.errors = Constants.FALSE;

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
		$scope.$parent.errors = Constants.FALSE;

	    self.principal = Constants.FALSE;
	    self.parent = Constants.FALSE;
	    self.reg = {} ;

	    switch(role) {
	      case Constants.PRINCIPAL :
	        self.required = Constants.FALSE;
	        self.role_click = Constants.TRUE;
	        self.principal = Constants.TRUE;
	        self.reg.client_role = Constants.PRINCIPAL;
	        break;

	      case Constants.PARENT    :
	      	self.required = Constants.TRUE;
	        self.role_click = Constants.TRUE;
	        self.parent = Constants.TRUE;
	        self.reg.client_role = Constants.PARENT;
	        break;

	      default:
	      	self.reg = {};
	        break;
	    }

	    $("#registration_form input, #registration_form select").removeClass("required-field");
	}

	function registerClient() {
	    $scope.$parent.errors = Constants.FALSE;

	    $("#registration_form input, #registration_form select").removeClass("required-field");
	    
	    if($scope.e_error || $scope.u_error) {
	      $("html, body").animate({ scrollTop: 320 }, "slow");
	    } else if(!this.terms) {
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
					self.registered = Constants.TRUE;
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
	    self.errors = Constants.FALSE;

	    self.user_type = Constants.CLIENT;
	    self.email = (!isStringNullorEmpty(self.email)) ? self.email : $("#registration_success_form input[name='email']").val();
	    this.base_url = $("#base_url_form input[name='base_url']").val();
	    this.resend_confirmation_url = this.base_url + Constants.URL_REGISTRATION(angular.lowercase(this.user_type));

	    $scope.ui_block();
	    apiService.resendConfirmation(self.email, self.user_type, this.resend_confirmation_url).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

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
			self.errors = $scope.internalError();
			$scope.ui_unblock();
	    });
	}

  	function confirmClientRegistration() {
  		self.errors = Constants.FALSE;
	    
	    self.user_type = Constants.CLIENT;
	    self.email = (!isStringNullorEmpty(self.email)) ? self.email : $("#registration_success_form input[name='email']").val();

	    $scope.ui_block();
	    apiService.confirmCode(self.email, self.confirmation_code, self.user_type).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					$scope.$parent.errors = Constants.FALSE;
					self.confirmed = Constants.TRUE;
					self.set.id = response.data.id;
				} 
			}

			$scope.ui_unblock();
	    }).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
	    });
	}

	self.getTeacherDetails = function(id, token) {
		self.fields = [];
		self.errors = Constants.FALSE;

		$scope.ui_block();
		clientLoginApiService.getTeacherDetails(id, token).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					if(!response.data) {
						self.errors = [Constants.MSG_NO_RECORD];
					} else {
						var data = response.data;
						self.record = {};
						self.record.id = data.id;
						self.record.email = data.user.email;
						self.record.username = data.user.username;
						self.record.first_name = data.first_name;
						self.record.last_name = data.last_name;
						self.record.school_name = data.school.name;
						self.record.registration_token = data.user.registration_token;
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateClientRegistration = function() {
		self.errors = Constants.FALSE;
		self.validation = {};
		self.fields = [];
		
		if(!angular.equals(self.record.password, self.record.confirm_password)) {
			self.fields['password'] = Constants.TRUE;
			self.errors = [Constants.MSG_PW_NOT_MATCH];
		} else if(!self.terms) {
	      self.errors = ["Please accept the terms and conditions."];
	    } else {
			var base_url = $("#base_url_form input[name='base_url']").val();
			self.record.callback_uri = base_url + Constants.URL_REGISTRATION(angular.lowercase(Constants.CLIENT));

			$scope.ui_block();
			clientLoginApiService.updateClientRegistration(self.record).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);

						angular.forEach(response.errors, function(value, key) {
							self.fields[value.field] = Constants.TRUE;
			            });
					} else if(response.data) {
						self.registered = Constants.TRUE;
						self.email = self.record.email;
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.checkAvailability = function(username, user_type) {
		self.validation.u_loading = Constants.TRUE;
		self.validation.u_success = Constants.FALSE;
		self.validation.u_error = Constants.FALSE;

		apiService.validateUsername(username, user_type).success(function(response) {
			self.validation.u_loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.validation.u_error = response.errors[0].message;

					if(angular.equals(self.validation.u_error, Constants.MSG_U_NOTEXIST)) {
						self.validation.u_error = Constants.FALSE;
						self.validation.u_success = Constants.MSG_U_AVAILABLE;
					}
				} else if(response.data) {
					if(angular.equals(response.data.id, self.record.id)) {
						self.validation.u_success = Constants.MSG_U_AVAILABLE;
					} else {
						self.validation.u_error = Constants.MSG_U_EXIST;  
					}
				}
			}
		}).error(function(response) {
			self.validation.u_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});
	}

	self.checkEmailAvailability = function(email, user_type) {
		self.validation.e_loading = Constants.TRUE;
		self.validation.e_success = Constants.FALSE;
		self.validation.e_error = Constants.FALSE;

		apiService.validateEmail(email, user_type).success(function(response) {
			self.validation.e_loading = Constants.FALSE;

			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.validation.e_error = response.errors[0].message;

					if(angular.equals(self.validation.e_error, Constants.MSG_EA_NOTEXIST)) {
						self.validation.e_error = Constants.FALSE;
						self.validation.e_success = Constants.MSG_EA_AVAILABLE;
					}
				} else if(response.data) {
					if(angular.equals(response.data.id, self.record.id)) {
						self.validation.e_success = Constants.MSG_EA_AVAILABLE;
					} else {
						self.validation.e_error =Constants.MSG_EA_EXIST;  
					}
				}
			}
		}).error(function(response) {
			self.validation.e_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});
	}  

	self.showModal = function(id) {
		$scope.show_terms = (id == 'terms_modal') ? Constants.TRUE : Constants.FALSE;
		$scope.show_policy = (id == 'policy_modal') ? Constants.TRUE : Constants.FALSE;
		$scope.show = Constants.TRUE;


		$("#"+id).modal({
				backdrop: 'static',
				keyboard: Constants.FALSE,
				show    : Constants.TRUE
		});
	}
}	