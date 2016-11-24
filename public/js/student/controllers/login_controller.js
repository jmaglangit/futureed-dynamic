angular.module('futureed.controllers')
	.controller('StudentLoginController', StudentLoginController);

StudentLoginController.$inject = ['$scope', '$filter', '$controller', 'StudentLoginService', 'MediaLoginService', 'ValidationService'];

function StudentLoginController($scope, $filter, $controller, StudentLoginService, MediaLoginService, ValidationService) {
	var self = this;

	self.manual = {};

	ValidationService(self);
	self.default();

	angular.extend(self, $controller('MediaLoginController', { $scope : $scope }));

	self.setSetUserType(Constants.STUDENT);
	self.fbAsyncInit();

	self.setActive = function(active) {
		self.errors = Constants.FALSE;
		self.record = {};

		self.active_login = Constants.FALSE;
		self.active_confirm = Constants.FALSE;
		self.active_enter_password = Constants.FALSE;
		self.active_registration = Constants.FALSE;
		self.active_resend = Constants.FALSE;

		switch(active) {
			case 'confirm_media'	:
				self.active_confirm = Constants.TRUE;
				break;

			case 'confirm_success'	:
				self.active_confirm_success = Constants.TRUE;
				break;

			case 'enter_password'	:
				self.active_enter_password = Constants.TRUE;
				break;

			case 'registration'	:
				self.active_registration = Constants.TRUE;
				break;

			case 'registration_success'	:
				self.active_registration_success = Constants.TRUE;
				break;

			case 'resend'			:
				self.active_resend = Constants.TRUE;
				break;

			case 'login'			:

			default					:
				self.active_login = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.setActive();

	$scope.$on('confirm-media', checkMediaLogin);

	function checkMediaLogin(event, data) {
		self.setActive('confirm_media');

		if(data.confirm) {
			if(angular.equals(data.media_type, Constants.GOOGLE)) {
				self.getGoogleDetails(function(response) {
					self.record = data;
					self.record.first_name = response.given_name;
					self.record.last_name = response.family_name;

					// apply before showing page
					$scope.$apply();
				});
			} else {
				self.record = data;
			}
		}

		// since API is strict with Gender case. Must be 'Male' or 'Female'; otherwise API will respond an error
		self.record.gender = (angular.equals(angular.lowercase(Constants.MALE), angular.lowercase(self.record.gender))) ? Constants.MALE : Constants.FEMALE;
	}

	self.confirmMediaDetails = function() {
		self.errors = Constants.FALSE;
		self.fields = [];

		if(!self.record.terms) {
			self.errors = ["Please accept the terms and conditions."];
			$("html, body").animate({ scrollTop: 0 }, "slow");
			return;
		}

		$("div.birth-date-wrapper select").removeClass("required-field");

		var birth_date = $("input#birth_date").val();
			self.record.birth_date = $filter(Constants.DATE)(new Date(birth_date), Constants.DATE_YYYYMMDD);

		$scope.ui_block();
		MediaLoginService.registerMedia(self.record, angular.lowercase(self.record.media_type)).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});

					if(self.fields['birth_date']) {
						$("div.birth-date-wrapper select").addClass("required-field");
					}
				} else if(response.data) {
					response.data.role = Constants.STUDENT;
					response.data.media_login = Constants.TRUE;
					
					$scope.user = JSON.stringify(response.data);
					self.setActive('confirm_success');
				} 
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.proceedToDashboard = function() {
		$("#process_form input[name='user_data']").val($scope.user);
		$("#process_form").submit();
	}

	function showModal(id) {
		self.show_terms = (id == 'terms_modal') ? Constants.TRUE : Constants.FALSE;
		self.show_policy = (id == 'policy_modal') ? Constants.TRUE : Constants.FALSE;
		self.show = Constants.TRUE;


		$("#"+id).modal({
				backdrop: 'static',
				keyboard: Constants.FALSE,
				show    : Constants.TRUE
		});
	}

	self.setDropdown = function (date) {
		var options = {
			submitFieldName: 'birth_date'
			, wrapperClass: 'birth-date-wrapper'
			, minAge: Constants.MIN_AGE
			, maxAge: Constants.MAX_AGE
		}

		if(date) {
			options.defaultDate = date;
		}

		$("#birth_date").dateDropdowns(options);
	}

	self.checkStudent = function(id) {
		if(id != Constants.EMPTY_STR) {
			self.manual.id = id;
			self.getLoginPassword();
			self.setActive('enter_password');
		}
	}

	self.validateUser = function(event) {
		event = getEvent(event);
		event.preventDefault();
		
		self.errors = Constants.FALSE;

		$scope.ui_block();
		StudentLoginService.validateUser(self.manual.username).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.manual.id = response.data.id;
					self.getLoginPassword();
				} 
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getLoginPassword = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		StudentLoginService.getLoginPassword(self.manual).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.image_pass = response.data;
					self.setActive('enter_password');
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.cancelLogin = function() {
		self.errors = Constants.FALSE;
		self.image_pass = [];
		self.manual = {};

		self.setActive();
	}

	self.selectPassword = function(image_id) {
		self.manual.image_id = image_id;
		self.validatePassword();
	}

	self.validatePassword = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		StudentLoginService.validatePassword(self.manual).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					
					self.image_pass = shuffle(self.image_pass);
				} else if(response.data){
					response.data.role = Constants.STUDENT;

					$scope.user = JSON.stringify(response.data);
					$("#process_form input[name='user_data']").val($scope.user);
					$("#process_form").submit();
				} 
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	} 

	/**
	* Student registration
	*/
	self.checkRegistration = function(email,code, id, token) {
		self.errors = Constants.FALSE;
		self.record.invited = Constants.FALSE;

		// If student is invited
		if(id && token) {
			StudentLoginService.getStudentDetails(id, token).success(function(response){
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);

						angular.forEach(self.errors, function(value) {
							if(angular.equals(value, "Registration token is invalid.")) {
								self.setActive('registration');

								self.record = {};
								self.record.invited = Constants.TRUE;
								self.errors = [value];
							}
						});
					} else if(response.data){
						self.setActive('registration');

						self.record = response.data[0];
						self.record.username = self.record.user.username;
						self.record.email = self.record.user.email;
						self.record.school_name = self.record.school.name;
						
						$scope.getGradeLevel(self.record.country_id);
						self.record.invited = Constants.TRUE;
					}
				}
			}).error(function(response){
				self.errors = $scope.internalError();
			});
		} else if(email) {
			self.linked = Constants.TRUE;
			self.setActive('registration_success');

			self.record.email = email;
			self.record.email_code = code;
			self.record.user_type = Constants.STUDENT;

			$scope.ui_block();
			StudentLoginService.confirmCode(self.record.email, self.record.email_code, self.record.user_type).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else if(response.data){
						$("#redirect_form input[name='id']").val(response.data.id);
						$("#redirect_form input[name='email']").val(self.record.email);
						$("#redirect_form input[name='confirmation_code']").val(self.record.email_code);
						$("#redirect_form").submit();

						self.confirmed = Constants.TRUE;
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		} else {

			self.setActive('registration');
		}
	}

	self.validateRegistration = function() {
		self.fields = [];
		self.errors = Constants.FALSE;

		if(!self.record.terms) {
			self.errors = ["Please accept the terms and conditions."];
			$("html, body").animate({ scrollTop: 0 }, "slow");
			return;
		}

		if (self.record.country_id == "" || self.record.country_id == null) {
			self.record.country_id = 0;
		}

		$("div.birth-date-wrapper select").removeClass("required-field");

		var birth_date = $("input#birth_date").val();
		self.record.birth_date = $filter(Constants.DATE)(new Date(birth_date), Constants.DATE_YYYYMMDD);

		var base_url = $("#base_url_form input[name='base_url']").val();
		self.record.callback_uri = base_url + Constants.URL_REGISTRATION(angular.lowercase(Constants.STUDENT));

		console.log(self.record);
		$scope.ui_block();
		StudentLoginService.validateRegistration(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});

					if(self.fields['birth_date']) {
						$("div.birth-date-wrapper select").addClass("required-field");
					}
				} else if(response.data) {
					var email = self.record.email;
					
					self.setActive('registration_success');
					self.record.email = email;
				}
			}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.editRegistration = function() {
		self.fields = [];
		self.errors = Constants.FALSE;

		if(!self.record.terms) {
			$scope.errors = ["Please accept the terms and conditions."];
			$("html, body").animate({ scrollTop: 0 }, "slow");
			return;
		}

		$("div.birth-date-wrapper select").removeClass("required-field");

		var birth_date = $("input#birth_date").val();
		self.record.birth_date = $filter(Constants.DATE)(new Date(birth_date), Constants.DATE_YYYYMMDD);

		var base_url = $("#base_url_form input[name='base_url']").val();
		self.record.callback_uri = base_url + Constants.URL_REGISTRATION(angular.lowercase(Constants.STUDENT));

		$scope.ui_block();
		StudentLoginService.editRegistration(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					$scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data){
					var email = self.record.email;
					
					self.setActive('registration_success');
					self.record.email = email;
				}
			}
			$scope.ui_unblock();
		}).error(function(response) {
			scope.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.studentConfirmRegistration = function(event) {
		event = getEvent(event);
		event.preventDefault();

		self.errors = Constants.FALSE;
		self.record.user_type = Constants.STUDENT;

		$scope.ui_block();
		StudentLoginService.confirmCode(self.record.email, self.record.email_code, self.record.user_type).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					$("#redirect_form input[name='id']").val(response.data.id);
					$("#redirect_form input[name='email']").val(self.record.email);
					$("#redirect_form input[name='confirmation_code']").val(self.record.email_code);
					$("#redirect_form").submit();
				} 
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.studentResendConfirmation = function () {
		self.errors = Constants.FALSE;
		var user_type = Constants.STUDENT;
		
		var base_url = $("#base_url_form input[name='base_url']").val();
		var resend_confirmation_url = base_url + Constants.URL_REGISTRATION(angular.lowercase(user_type));
		var email = self.record.email;

		$scope.ui_block();
		StudentLoginService.resendConfirmation(email, user_type, resend_confirmation_url).success(function(response) {
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
}