angular.module('futureed.controllers')
	.controller('ProfileController', ProfileController);

ProfileController.$inject = ['$scope', 'apiService', 'clientProfileApiService'];

function ProfileController($scope, apiService, clientProfileApiService) {
	var self = this;
	self.prof = {};
	self.change = {};
	self.confirm = {};
	self.user_type = Constants.CLIENT;

	self.setClientProfileActive = setClientProfileActive;
	self.getClientDetails = getClientDetails;
	self.checkAvailability = checkAvailability;
	self.saveClientProfile = saveClientProfile;

	self.validateCurrentClientEmail = validateCurrentClientEmail;
	self.validateNewClientEmail = validateNewClientEmail;
	self.confirmNewEmail = confirmNewEmail;
	self.changeClientEmail = changeClientEmail;
	self.confirmClientEmail = confirmClientEmail;
	self.resendClientEmailCode = resendClientEmailCode;
	
	self.changeClientPassword = changeClientPassword;

	function setClientProfileActive(active) {
	    self.errors = Constants.FALSE;
	    self.success = Constants.FALSE;

	    self.change = {};
	    self.validation = {};
	    self.password_changed = Constants.FALSE;
	    self.email_confirmed = Constants.FALSE;

		self.active_index = Constants.FALSE;
	    self.active_edit = Constants.FALSE;
	    self.active_password = Constants.FALSE;
	    self.active_edit_email = Constants.FALSE;
	    self.active_confirm_email = Constants.FALSE;

	    switch(active) {
	      case Constants.PASSWORD 	:
	      	self.active_password = Constants.TRUE;
	        break;

	      case Constants.EDIT 		:
	      	self.getClientDetails();
	      	self.active_edit = Constants.TRUE;
	      	break;

	      case Constants.EDIT_EMAIL	:
	      	self.change = {};
	      	self.active_edit_email = Constants.TRUE;
	      	break;

	      case Constants.CONFIRM_EMAIL :
	      	self.resent = Constants.FALSE;
	      	self.confirmation_code = Constants.EMPTY_STR;
	      	self.active_confirm_email = Constants.TRUE;
	        break;

	      case Constants.INDEX    	:
	      default:
	        self.getClientDetails();
	        self.active_index = Constants.TRUE;
	        self.active_password = Constants.FALSE;
	        self.active_edit = Constants.FALSE;
	        break;
	    }

	    $('input, select').removeClass('required-field');
	    $("html, body").animate({ scrollTop: 0 }, "slow");
	}

	function getClientDetails() {
		self.errors = Constants.FALSE;
		$scope.ui_block();
		clientProfileApiService.getClientDetails($scope.user.id).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					$scope.errorHandler(response.errors);
				} else if(response.data) {
					self.prof = response.data;

					if(angular.equals(self.prof.client_role, Constants.PRINCIPAL)) {
						self.is_principal = Constants.TRUE;
					} else if(angular.equals(self.prof.client_role, Constants.PARENT)) {
						self.is_parent = Constants.TRUE;
						self.is_required = Constants.TRUE;
					} else if(angular.equals(self.prof.client_role, Constants.TEACHER)) {
						self.is_teacher = Constants.TRUE;
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function checkAvailability() {
	    self.validation.u_loading = Constants.TRUE;
	    self.validation.u_success = Constants.FALSE;
	    self.validation.u_error = Constants.FALSE;

	    apiService.validateUsername(self.prof.username, self.user_type).success(function(response) {
	      self.validation.u_loading = Constants.FALSE;

	      if(angular.equals(response.status, Constants.STATUS_OK)) {
	        if(response.errors) {
	          self.validation.u_error = response.errors[0].message;

	          if(angular.equals(self.validation.u_error, Constants.MSG_U_NOTEXIST)) {
	          	self.validation.u_error = Constants.FALSE;
	            self.validation.u_success = Constants.TRUE;
	          }
	        } else if(response.data) {
	          if(response.data.id == self.prof.id) {
	            self.validation.u_success = Constants.TRUE ;
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

	function saveClientProfile() {
		self.errors = Constants.FALSE;

		if(self.validation.u_error) {
			$("html, body").animate({ scrollTop: 0 }, "slow");
		} else {
			$('input, select').removeClass('required-field');

			$scope.ui_block();
			clientProfileApiService.saveClientProfile(self.prof).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);

						angular.forEach(response.errors, function(value, key) {
			              $("#client_profile_form input[name='" + value.field +"']").addClass("required-field");
			              $("#client_profile_form select[name='" + value.field +"']").addClass("required-field");
			            });
					} else if(response.data) {
						self.prof = {};
						$scope.$parent.user = response.data;
						response.data.role = response.data.client_role;
						
						clientProfileApiService.updateUserSession(response.data).success(function(response) {
							self.setClientProfileActive(Constants.INDEX);
							self.success = Constants.TRUE;
			            }).error(function() {
							$scope.internalError();
			            });
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		}
	}

	/**
	* Validate if input is the current email address
	*
	* @Params
	* 	[Object] change 				- the change / edit email fields
	*	[String] change.current_email	- the current email
	*	[String] user_type				- the user type, Client
	*/
	function validateCurrentClientEmail() {
		self.errors = Constants.FALSE;
		self.validation.e_error = Constants.FALSE;
		self.validation.e_success = Constants.FALSE;
		self.validation.e_loading = Constants.TRUE;

		apiService.validateEmail(self.change.current_email, self.user_type).success(function(response) {
			self.validation.e_loading = Constants.FALSE;

		    if(angular.equals(response.status, Constants.STATUS_OK)) {
		        if(response.errors) {
		            self.validation.e_error = response.errors[0].message;
		        } else if(response.data) {
		        	if(angular.equals(self.prof.email, self.change.current_email)) {
		          		self.validation.e_success = Constants.TRUE;
		        	} else {
		        		self.validation.e_error = Constants.MSG_EA_CURR_NOTMATCH;
		        	}
		        }
		    }

		}).error(function(response) {
			self.validation.e_loading = Constants.FALSE;
			self.errors = $scope.internalError();
		});
	}

	function validateNewClientEmail() {
		self.errors = Constants.FALSE;
		// Clear error messages in new email field
		self.validation.n_error = Constants.FALSE;
		self.validation.n_success = Constants.FALSE;
		self.validation.n_loading = Constants.TRUE;

		// Clear error messages in confirm email field
		self.validation.c_error = Constants.FALSE;
		self.validation.c_success = Constants.FALSE;

		apiService.validateEmail(self.change.new_email, self.user_type).success(function(response) {
			self.validation.n_loading = Constants.FALSE;

		    if(angular.equals(response.status, Constants.STATUS_OK)) {
		        if(response.errors) {
		            self.validation.n_error = response.errors[0].message;
		            if(angular.equals(self.validation.n_error, Constants.MSG_EA_NOTEXIST)) {
		            	self.validation.n_error = Constants.FALSE;

		            	if(!angular.equals(self.change.new_email, self.change.confirm_email)) {
							self.validation.n_success = Constants.TRUE;

							self.validation.c_error = Constants.MSG_EA_CONFIRM;
						} else {
							self.validation.n_success = Constants.TRUE;
							self.validation.c_success = Constants.TRUE;
						}
		            }
		        } else if(response.data) {
		        	self.validation.n_error = Constants.MSG_EA_EXIST;
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

	/**
	* Save new email to repository, send email to client
	*
	*/
	function changeClientEmail() {
		self.errors = Constants.FALSE;

		if(self.validation.e_success && self.validation.n_success && self.validation.c_success) {
			self.base_url = $("#base_url_form input[name='base_url']").val();
		    self.callback_uri = self.base_url + Constants.URL_CHANGE_EMAIL(angular.lowercase(Constants.CLIENT));

			$scope.ui_block();
			clientProfileApiService.changeClientEmail($scope.user.id, self.change, self.callback_uri).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else if(response.data) {
						self.prof.new_email = self.change.new_email;
						self.setClientProfileActive(Constants.CONFIRM_EMAIL);
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		} else {
	    	$("html, body").animate({ scrollTop: 0 }, "slow");
		}
	}

	function confirmClientEmail() {
		self.errors = Constants.FALSE;
		self.user_type = Constants.CLIENT;
		self.prof.new_email = (self.prof.new_email) ? self.prof.new_email : $("#confirm_email_form input[name='new_email']").val();

		$scope.ui_block();
		clientProfileApiService.confirmClientEmail($scope.user.id, self.user_type, self.confirmation_code, self.prof.new_email).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.email_confirmed = Constants.TRUE;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function resendClientEmailCode() {
		self.errors = Constants.FALSE;
		self.user_type = Constants.CLIENT;
		self.base_url = $("#base_url_form input[name='base_url']").val();
	    self.callback_uri = self.base_url + Constants.URL_CHANGE_EMAIL(angular.lowercase(Constants.CLIENT));

	    $scope.ui_block();
		clientProfileApiService.resendClientEmailCode($scope.user.id, self.user_type, self.callback_uri).success(function(response) {
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

	function changeClientPassword() {
		self.errors = Constants.FALSE;
		$("#client_change_pass_form input").removeClass("required-field");

		if(angular.equals(self.change.new_password, self.change.confirm_password)) {
			$scope.ui_block();
			clientProfileApiService.changeClientPassword($scope.user.id, self.change).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);

						angular.forEach(response.errors, function(value, key) {
			              $("#client_change_pass_form input[name='" + value.field +"']").addClass("required-field");
			            });
					} else if(response.data) {
						self.password_changed = Constants.TRUE;
						self.change = {};
					}
				} 

				$scope.ui_unblock();
			}).error(function(response) {
				$scope.internalError();
				$scope.ui_unblock();
			});
		} else {
			self.errors = [Constants.MSG_PW_NOT_MATCH];
			$("#client_change_pass_form input[name='new_password']").addClass("required-field");
			$("#client_change_pass_form input[name='confirm_password']").addClass("required-field");
		}
	}
}