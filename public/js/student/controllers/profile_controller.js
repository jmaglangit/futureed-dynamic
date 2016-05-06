angular.module('futureed.controllers')
	.controller('ProfileController', ProfileController);

ProfileController.$inject = ['$scope', '$timeout','apiService', 'ProfileService'];

function ProfileController($scope, $timeout,apiService, ProfileService) {
	var self = this;
	self.prof = {};
	self.user_type = Constants.STUDENT;
	
	self.setStudentProfileActive = setStudentProfileActive;

	self.studentDetails = studentDetails;
	self.saveProfile = saveProfile;

	self.validateStudentCurrentEmail = validateStudentCurrentEmail;
	self.validateStudentNewEmail = validateStudentNewEmail;
	self.confirmStudentNewEmail = confirmStudentNewEmail;
	self.backToEditEmail = backToEditEmail;
	self.selectPicturePassword = selectPicturePassword;
	self.changeStudentEmail = changeStudentEmail;

	self.confirmStudentEmailCode = confirmStudentEmailCode;
	self.resendStudentEmailCode = resendStudentEmailCode;

	self.getAvatarImages = getAvatarImages;
	self.highlightAvatar = highlightAvatar;
	self.selectAvatar = selectAvatar;

	$scope.$watch("profile.avatar_accessories", function (newValue, oldValue) {
		$timeout(function() {
			$('.avtr-accessory').each(function() {
				$(this).magnificPopup({
					delegate: '.accessory-img',
					type:'image',
				});
			});
		});
	});

	function setStudentProfileActive(active) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.$parent.u_error = Constants.FALSE;
		$scope.$parent.u_success = Constants.FALSE;

		self.password_validated = Constants.FALSE;
		self.password_selected = Constants.FALSE;
		self.password_confirmed = Constants.FALSE;

		self.active_index = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_confirm_email = Constants.FALSE;
		self.active_edit_email = Constants.FALSE;
		self.active_avatar = Constants.FALSE;
		self.active_rewards = Constants.FALSE;
		self.active_password = Constants.FALSE;
		self.active_reports = Constants.FALSE;
		self.active_avatar_accessory = Constants.FALSE;
		self.buy_avatar_accessory_modal = Constants.FALSE;
		self.settings = Constants.FALSE;

		self.validation = {};
		self.select_password = Constants.FALSE;
		self.email_confirmed = Constants.FALSE;

		switch (active) {

			case Constants.REWARDS        :
				self.active_rewards = Constants.TRUE;
				self.getPoints();
				self.getBadges();
				self.getPointLevel();
				break;

			case 'reports'        :
				self.active_reports = Constants.TRUE;
				break;

			case Constants.AVATAR        :
				self.enable = Constants.FALSE;
				self.active_avatar = Constants.TRUE;
				break;

			case Constants.PASSWORD        :
				self.change = {};

				self.getLoginPassword();
				self.active_password = Constants.TRUE;
				break;

			case Constants.EDIT            :
				self.studentDetails();
				self.active_edit = Constants.TRUE;
				break;

			case Constants.EDIT_EMAIL :
				if (!$scope.user.media_login) {
					self.change = {};
					self.studentDetails();
					self.active_edit_email = Constants.TRUE;
				}
				break;

			case Constants.CONFIRM_EMAIL  :
				self.resent = Constants.FALSE;
				self.confirmation_code = Constants.EMPTY_STR;
				self.active_confirm_email = Constants.TRUE;
				break;

			case Constants.AVATAR_ACCESSORY:
				self.active_avatar_accessory = Constants.TRUE;
				break;

			case Constants.SETTINGS    :
				self.settings = Constants.TRUE;
				self.getStudentBackgroundImage();
				break;

			case Constants.INDEX            :
			default:
				self.studentDetails();
				self.active_index = Constants.TRUE;
				break;
		}

		$('input, select').removeClass('required-field');
		$("html, body").animate({scrollTop: 0}, "slow");
	  }

	  function studentDetails() {
		self.errors = Constants.FALSE;
		$scope.ui_block();
		apiService.studentDetails($scope.user.id).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.prof = response.data[0];
					self.prof.birth = self.prof.birth_date;

					self.getGradeLevel();

					self.dateDropdown(self.prof.birth_date);
				} 
			}

			$scope.ui_unblock();
		}).error(function(response) {
		  self.errors = $scope.internalError();
		  $scope.ui_unblock();
		});
	  }

	  self.setCountryGrade = function() {
		// Set Grade Code to empty string
		self.prof.grade_code = Constants.EMPTY_STR;
		self.getGradeLevel();

		// Get Country details, set country name
		self.prof.country = Constants.EMPTY_STR;
		ProfileService.getCountryDetails(self.prof.country_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(response.data.length) {
						self.prof.country = response.data[0].name;
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	  }

	  self.getGradeLevel = function() {
		self.grades = Constants.FALSE;

		apiService.getGradeLevel(self.prof.country_id).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.grades = response.data.records;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	  }

	  function saveProfile() {
		self.errors = Constants.FALSE;
		self.fields = [];

		if($scope.e_error || $scope.u_error) {
			$("html, body").animate({ scrollTop: 350 }, "slow");
		} else {
		  self.prof.school_code = 1;
			var day = $("#profile_form .day").val();
			var month = $("#profile_form .month").val();
			var year = $("#profile_form .year").val();

			self.prof.birth_date = year + month + day;

		  $scope.ui_block();
		  apiService.saveProfile(self.prof).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
			  if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);

				angular.forEach(response.errors, function(value, key) {
					self.fields[value.field] = Constants.TRUE;
				});
			  } else if(response.data){
				self.prof = {};
				$scope.$parent.user = response.data;

				apiService.updateUserSession(response.data).success(function(response) {
				  self.setStudentProfileActive(Constants.INDEX);
				  self.success = Constants.TRUE;
				}).error(function() {
				  self.errors = $scope.internalError();
				});
				
			  }
			} 

			$scope.ui_unblock();
		  }).error(function(response) {
			$scope.ui_unblock();
			self.errors = $scope.internalError();
		  });
		}
	  }

	  function validateStudentCurrentEmail() {
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
			self.erros = $scope.internalError();
			self.validation.e_loading = Constants.FALSE;
		});
	  }

	  function validateStudentNewEmail() {
		self.errors = Constants.FALSE;
		self.validation.n_error = Constants.FALSE;
		self.validation.n_success = Constants.FALSE;

		self.validation.c_error = Constants.FALSE;
		self.validation.c_success = Constants.FALSE;

		self.validation.n_loading = Constants.TRUE;

		apiService.validateEmail(self.change.new_email, self.user_type).success(function(response) {
			self.validation.n_loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.validation.n_error = response.errors[0].message;
					if(angular.equals(self.validation.n_error, Constants.MSG_EA_NOTEXIST)) {
						self.validation.n_error = Constants.FALSE;

						if(!angular.equals(self.change.new_email, self.change.confirm_email)) {
							self.validation.c_error = Constants.MSG_EA_CONFIRM;
							self.validation.n_success = Constants.TRUE;
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
			self.erros = $scope.internalError();
			self.validation.n_loading = Constants.FALSE;
		});
	  }

	  function confirmStudentNewEmail() {
		self.errors = Constants.FALSE;
		self.validation.c_error = Constants.FALSE;
		self.validation.c_success = Constants.FALSE;
		
		if(!angular.equals(self.change.new_email, self.change.confirm_email)) {
			self.validation.c_error = Constants.MSG_EA_NOT_MATCH;
		} else {
			self.validation.c_success = Constants.TRUE;
		}
	  }

	  function backToEditEmail() {
		self.errors = Constants.FALSE;
		self.image_id = Constants.EMPTY_STR;
		self.select_password = Constants.FALSE;
	  }

	  function selectPicturePassword() {
		self.errors = Constants.FALSE;
		self.fields = [];

		if(self.validation.e_success && self.validation.n_success && self.validation.c_success) {
			self.select_password = Constants.TRUE;
			self.getLoginPassword();
		} else {
			if(!self.change.current_email) {
				self.fields['current_email'] = Constants.TRUE;
				self.errors = [];
				self.errors.push("Current email address is required.");
			}

			if(!self.change.new_email) {
				self.fields['new_email'] = Constants.TRUE;
				self.errors = (self.errors) ?  self.errors : [];
				self.errors.push("New email address is required.");
			}

			if(!self.change.confirm_email) {
				self.fields['confirm_email'] = Constants.TRUE;
				self.errors = (self.errors) ?  self.errors : [];
				self.errors.push("Confirm email address is required.");
			}

			$("html, body").animate({ scrollTop: 0 }, "slow");
		}
	  }

	  function changeStudentEmail() {
		self.errors = Constants.FALSE;
		self.base_url = $("#base_url_form input[name='base_url']").val();
		self.callback_uri = self.base_url + Constants.URL_CHANGE_EMAIL(angular.lowercase(Constants.STUDENT));

		  $scope.ui_block();
		  apiService.changeValidate(self.prof.id, self.change.new_email, self.change.password_image_id, self.callback_uri).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
			  if(response.errors){
				self.errors = $scope.errorHandler(response.errors);
			  }else if(response.data){
				self.setStudentProfileActive(Constants.CONFIRM_EMAIL);
				self.prof.new_email = self.change.new_email;
			  }
			}
			$scope.ui_unblock();
		  }).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		  });
	  }

	  function confirmStudentEmailCode() {
			self.errors = Constants.FALSE;
			self.prof.new_email = (self.prof.new_email) ? self.prof.new_email : $("#confirm_email_form input[name='new_email']").val();

			$scope.ui_block();
			apiService.emailValidateCode(self.prof.new_email, self.user_type , self.confirmation_code).success(function(response){
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors){
						self.errors = $scope.errorHandler(response.errors);
					} else if(response.data) {
						self.email_confirmed = Constants.TRUE;
						self.prof.email = self.prof.new_email;
						self.prof.new_email = Constants.EMPTY_STR;
					}
				}

				$scope.ui_unblock();
			}).error(function(response){
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			}); 
	  }

	  function resendStudentEmailCode() {
			self.errors = Constants.FALSE;
			self.base_url = $("#base_url_form input[name='base_url']").val();
			self.callback_uri = self.base_url + Constants.URL_CHANGE_EMAIL(angular.lowercase(Constants.STUDENT));

			$scope.ui_block();
			apiService.emailResendCode(self.prof.id, self.new_email, self.user_type, self.callback_uri).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
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

	  function getAvatarImages() {
	  	$scope.ui_block();
		apiService.getAvatarImages(self.prof.gender).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
			  if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			  } else if(response.data){

				self.avatars = response.data;
			  }
			}
		$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	  }

	self.getAvatarAccessories = function(){
		$scope.ui_block();
		apiService.getAvatarAccessories($scope.user.id).success(function(response){
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.has_accessories = Constants.FALSE;
					self.errors = $scope.errorHandler(response.errors);
				}
				else if(response.data){
					self.has_accessories = Constants.TRUE;
					self.avatar_accessories = response.data;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.confrimBuyAvatarAccessory = function(accessory_id, points_to_unlock){
		self.accessory_id = accessory_id;
		self.points_to_unlock = points_to_unlock;

		self.buy_avatar_accessory_modal = Constants.TRUE;
		self.errors = Constants.FALSE;

		$("#buy_avatar_accessory_modal").modal({
			backdrop : 'static',
			keyboard : Constants.FALSE,
			show : Constants.TRUE
		});
	}

	self.buyAvatarAccessory = function(accessory_id, points_to_unlock){
		student_id = $scope.user.id;

		apiService.buyAvatarAccessory(student_id, accessory_id, points_to_unlock).success(function(response){
			if(response.status == Constants.STATUS_OK){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					$('#buy_avatar_accessory_modal').modal('toggle');
				}
				else if(response.data) {
					self.getAvatarAccessories();
					$scope.getUserPoints();
					$('#buy_avatar_accessory_modal').modal('toggle');
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	function highlightAvatar(e) {
		var target = getTarget(e);

		$("ul.avatar_list li").removeClass('selected');
		$(target).addClass('selected');
		self.avatar_id = $(target).find("#avatar_id").val(); 
		self.enable = Constants.TRUE;
	}

	function selectAvatar() {
		$scope.ui_block();
		apiService.selectAvatar(self.prof.id, self.avatar_id).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.prof.avatar_id = response.data.id;
					self.prof.avatar = response.data.url;
					self.prof.background = response.data.background_url;
					self.prof.thumbnail = response.data.thumbnail;
					self.prof.class = $scope.user.class;

					$("ul.avatar_list li").removeClass('selected');

					self.success = Constants.TRUE;
					$scope.updateUserData(self.prof);
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
		self.change.id = self.prof.id;

		$scope.ui_block();
		ProfileService.getLoginPassword(self.change).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.image_pass = response.data;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.highlightPassword = function(image_id) {
		self.change.password_image_id = image_id;
	}

	self.validateCurrentPassword = function() {
		self.errors = Constants.FALSE;

		if(self.change.password_image_id) {
		  	$scope.ui_block();
		  	ProfileService.validateCurrentPassword(self.change).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
			  	if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
			  	} else if(response.data) {
			  		self.change.password_image_id = Constants.FALSE;

					self.password_validated = Constants.TRUE;
					self.getImagePassword();
			  } 
			}

			$scope.ui_unblock();
		  }).error(function(response) {
			$scope.ui_unblock();
			self.errors = $scope.internalError();
		  });
		} else {
		  self.errors = [Constants.MSG_PPW_INCORRECT];
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.getImagePassword = function() {
		ProfileService.getImagePassword().success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.image_pass = response.data;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.selectNewPassword = function() {
		self.errors = Constants.FALSE;
		self.password_selected = Constants.FALSE;
		
		if(self.change.password_image_id) {
		  	self.password_selected = Constants.TRUE;
		  
		  	self.new_password = self.change.password_image_id;
		  	self.change.password_image_id = Constants.FALSE;
		  	self.image_pass = shuffle(self.image_pass);
		} else {
		  	self.errors = [Constants.MSG_PPW_SELECT_NEW];
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	  }

	self.undoNewPassword = function() {
		self.errors = Constants.FALSE;
		self.password_selected = Constants.FALSE;
		self.change.password_image_id = self.new_password;
		self.image_pass = shuffle(self.image_pass);

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.changePassword = function() {
		self.errors = Constants.FALSE;

		if(angular.equals(self.new_password, self.change.password_image_id)) {

			$scope.ui_block();
			ProfileService.changePassword(self.change).success(function(response) {
			  if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
				  		self.errors = $scope.errorHandler(response.errors);
					} else if(response.data){
				  		self.password_confirmed = Constants.TRUE;
				  		self.image_pass = [];
					} 
			  }

			  $scope.ui_unblock();
			}).error(function(response) {
			  self.errors = $scope.internalError();
			  $scope.ui_unblock();
			});
			
		} else {
			if(!self.change.password_image_id) {
				self.errors = [Constants.MSG_PPW_SELECT];
			} else {
				self.errors = [Constants.MSG_PPW_NOT_MATCH];
			}
			
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}
	}

	self.getBadges = function() {
		var id = $scope.user.id;

		$scope.ui_block();
		ProfileService.getBadges(id).success(function(response){
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
				  self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
				  self.badges = response.data.records;

				  angular.forEach(self.badges,function(value,key){
					value.badge_path = '/images/badges/' + value.badges.badge_image;
				  });
				} 
			  }
			  $scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getPoints = function() {
		var id = $scope.user.id;

		$scope.ui_block();
		ProfileService.getPoints(id).success(function(response){
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
				  self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
				  self.points = response.data.records;
				} 
			  }
			  $scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getPointLevel = function() {
		$scope.ui_block();
		ProfileService.getPointLevel(self.prof.points).success(function(response){
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.point_level = response.data.records;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.dateDropdown = function(date) {
		$("#birth_date").dateDropdowns({
			defaultDate : date,
			submitFieldName: 'birth_date',
			wrapperClass: 'birth-date-wrapper',
			minAge: Constants.MIN_AGE,
			maxAge: Constants.MAX_AGE
		});
		
		if(self.active_edit == Constants.FALSE) {
			$(".day").attr('disabled', 'disabled');
			$(".month").attr('disabled', 'disabled');
			$(".year").attr('disabled', 'disabled');
		}else {
			$(".day").prop('disabled', false);
			$(".month").prop('disabled', false);
			$(".year").prop('disabled', false);
		}
	}

	self.getStudentBackgroundImage = function(){
		self.background_image = {};

		ProfileService.getStudentBackgroundImage($scope.user.user.id).success(function(response){
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else if(response.data == Constants.FALSE) {
				self.background_image.url = "/images/class-student/mountain-full-bg.png";
			}else {
				self.background_image = response.data;
			}

		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateStudentBackgroundImage = function(image){

		var data = {};

		data.background_image_id = image.id;
		data.user_id = $scope.user.user.id;

		ProfileService.updateStudentBackgroundImage(data).success(function(response){
			if(response.errors) {
				self.errors = $scope.errorHandler(response.errors);
			} else if(response.data){
				self.background_image = image;
			}

		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getBackgroundImage = function() {
		self.background_image_list = {};
		self.background_image_total = 0;

		ProfileService.getBackgroundImage().success(function(response){

			if(response.data){
				self.background_image_list = response.data.records;
				self.background_image_total = response.data.total;
			}
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}