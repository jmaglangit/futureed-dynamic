angular.module('futureed.controllers', ['ngFileUpload', 'as.sortable'])
	.controller('futureedController', FutureedController)
	.directive('templateDirective', TemplateDirective)
	.constant("futureed", Constants);

function TemplateDirective() {
	return {
		templateUrl : function(scope, element, attrs) {
			return element.templateUrl;
		}
	}
}

function FutureedController($scope, $window, apiService, futureed) {
	$scope.futureed = futureed;
	$scope.display_date = new Date();
	
	/**
	* Common API calls
	*/
	$scope.highlight = highlight;
	$scope.errorHandler = function(errors, noScroll) {
		$scope.errors = [];

		if(angular.isArray(errors)) {
			angular.forEach(errors, function(value, key) {

				if(value.error_code == 2102) {
					$scope.user = null;

					apiService.updateUserSession($scope.user).success(function(response) {
						$scope.session_expire = Constants.TRUE;
						$("#session_expire").modal({
							backdrop: 'static',
							keyboard: Constants.FALSE,
							show    : Constants.TRUE
						});
					}).error(function() {
						$scope.internalError();
					});
				}

				if (angular.equals($scope.errors.indexOf(value.message), -1)) {
					$scope.errors[key] = value.message;
				}
			});
		} else {
			$scope.errors[0] = errors.message;
		}
		if(!noScroll) {
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}
		return $scope.errors;
	}

	$scope.internalError = function() {
		$scope.errors = [Constants.MSG_INTERNAL_ERROR];
		$("html, body").animate({ scrollTop: 0 }, "slow");

		return $scope.errors;
	}

	$scope.ui_block = function() {
		$.blockUI({ 
				message : '<img class="loader" src="/images/loading.png" /> Please wait... '
				, baseZ	: 2000
				, css 	: {
					  'border-radius' 		: '10px'
					, 'width' 	  			: '24%'
					, 'left' 	  			: '40%'
					, 'background-color'	: 'rgba(255, 255, 255, .4)'
				}
			});
	}

	$scope.ui_unblock = function() {
		var url = window.location.pathname;
		var segment = url.split('/');

		if(localStorage.token_expire == Constants.TRUE) {
			if(segment[1] == 'student') {
				$scope.user = null;

				apiService.updateUserSession($scope.user).success(function(response) {
					$scope.session_expire = Constants.TRUE;
					$("#session_expire").modal({
						backdrop: 'static',
						keyboard: Constants.FALSE,
						show    : Constants.TRUE
					});
				}).error(function() {
					$scope.internalError();
				});
			} else if(segment[1] == 'client') {
				$scope.user = null;

				apiService.updateClientUserSession($scope.user).success(function(response) {
					$scope.session_expire = Constants.TRUE;
					$("#session_expire").modal({
						backdrop: 'static',
						keyboard: Constants.FALSE,
						show    : Constants.TRUE
					});
				}).error(function() {
					$scope.internalError();
				});
			} else if(segment[1] == 'peaches') {
				$scope.user = null;

				apiService.updateAdminUserSession($scope.user).success(function(response) {
					$scope.session_expire = Constants.TRUE;
					$("#session_expire").modal({
						backdrop: 'static',
						keyboard: Constants.FALSE,
						show    : Constants.TRUE
					});
				}).error(function() {
					$scope.internalError();
				});
			}
		}

		if(localStorage.multiple_session == Constants.TRUE) {
			$scope.user = null;
			if(segment[1] == 'student')
			{
				apiService.updateUserSession($scope.user).success(function(response) {
					$scope.multiple_session = Constants.TRUE;
					$("#multiple_session").modal({
						backdrop: 'static',
						keyboard: Constants.FALSE,
						show    : Constants.TRUE
					});
				}).error(function() {
					$scope.internalError();
				});
			}
			else if(segment[1] == 'client')
			{
				apiService.updateClientUserSession($scope.user).success(function(response) {
					$scope.multiple_session = Constants.TRUE;
					$("#multiple_session").modal({
						backdrop: 'static',
						keyboard: Constants.FALSE,
						show    : Constants.TRUE
					});
				}).error(function() {
					$scope.internalError();
				});
			}
			else if(segment[1] == 'peaches')
			{
				apiService.updateAdminUserSession($scope.user).success(function(response) {
					$scope.multiple_session = Constants.TRUE;
					$("#multiple_session").modal({
						backdrop: 'static',
						keyboard: Constants.FALSE,
						show    : Constants.TRUE
					});
				}).error(function() {
					$scope.internalError();
				});
			}
		}
		$.unblockUI();
	}

	$scope.div_block = function(id) {
		$("#" + id).block({
				message : '<img src="/images/ajax-loader.gif" /> Please Wait...'
				, css 	: {
					  'border' 				: 'none'
					, 'border-radius' 		: '5px'
					, 'top' 	  			: '40%'
					, 'width' 	  			: '40%'
					, 'left' 	  			: '40%'
					, 'background-color'	: 'rgba(255, 255, 255, .4)'
				}
			});
	}

	$scope.div_unblock = function(id) {
		$("#" + id).unblock();
	}

	$scope.logout = function(id, user_type, callback) {
		var data = {
			id	: id
			, user_type : user_type
		}

		apiService.logout(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					$scope.errorHandler(response.errors);
				} else if(response.data) {
					$window.location.href = callback;
					localStorage.authorization = 0;
				}
			}
		}).error(function() {
			$scope.internalError();
		});
	}

	$scope.stopImpersonate = function(id,callback) {
		var data = {
			id	: id
		}

		apiService.stopImpersonate(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					$scope.errorHandler(response.errors);
				} else if(response.data) {
					$window.location.href = callback;
				}
			}
		}).error(function() {
			$scope.internalError();
		});
	}

	function highlight(e) {
		var target = getTarget(e);    

		$("ul.form_password li").removeClass('selected');
		$(target).addClass('selected');
		$scope.image_id = $(target).find("#image_id").val();
	}

	/**
	* Retrieves a list of countries
	*/
	$scope.getCountries = function() {
		$scope.countries = Constants.FALSE;

		apiService.getCountries().success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					$scope.errorHandler(response.errors);
				} else if(response.data) {
					$scope.countries = response.data;
				}
			}
		}).error(function(response) {
			$scope.internalError();
		});
	}
	
	$scope.getGradeLevel = function(country_id) {
		$scope.grades = Constants.FALSE;

		apiService.getGradeLevel(country_id).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					$scope.errorHandler(response.errors);
				} else if(response.data) {
					$scope.grades = response.data.records;
				}
			}
		}).error(function(response) {
			$scope.internalError();
		});
	}

	$scope.checkAvailability = function(username, user_type) {
		$scope.u_loading = Constants.TRUE;
		$scope.u_success = Constants.FALSE;
		$scope.u_error = Constants.FALSE;

		apiService.validateUsername(username, user_type).success(function(response) {
			$scope.u_loading = Constants.FALSE;

			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					if(response.errors[0].error_code == 2001) {
						// In registration and Edit Profile
						$scope.u_success = "Username is available." ;
					} else {
						$scope.u_error = response.errors[0].message;
					}
				} else if(response.data) {
					if($scope.user && (response.data.id == $scope.user.id)) {
						// In Edit Profile
						$scope.u_success = "Username is available." ;
					} else {
						$scope.u_error = "Username already exists.";  
					}
				}
			}
		}).error(function(response) {
			$scope.u_loading = Constants.FALSE;
			$scope.internalError();
		});
	}

	$scope.checkEmailAvailability = function(email, user_type) {
		$scope.e_loading = Constants.TRUE;
		$scope.e_success = Constants.FALSE;
		$scope.e_error = Constants.FALSE;

		apiService.validateEmail(email, user_type).success(function(response) {
			$scope.e_loading = Constants.FALSE;

			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					if(response.errors[0].error_code == 2002) {
						$scope.e_success = Constants.TRUE;
					} else {
						$scope.e_error = response.errors[0].message;
					}
				} else if(response.data) {
					if($scope.user && (response.data.id == $scope.user.id)) {
						$scope.e_success = Constants.TRUE;
					} else {
						$scope.e_error = "Email Address already exists.";  
					}
				}
			}
		}).error(function(response) {
			$scope.e_loading = Constants.FALSE;
			$scope.internalError();
		});
	}  
	/**
	* End of Common Functions / API calls
	*/

	/**
	* Student Page with API calls
	*/
	// Registration
	$scope.showModal = showModal;

	// Profile
	$scope.getImagePassword = getImagePassword;

	$scope.getAvatarImages = getAvatarImages;
	$scope.highlightAvatar = highlightAvatar;
	$scope.selectAvatar = selectAvatar;

	$scope.getUserDetails = function() {
		var user = $("input[name='userdata']").val();

		if(angular.isString(user) && user.length > 0) {
			$scope.user = JSON.parse(user);
			
			if ($scope.user.age) {
				$scope.user.age = parseInt($scope.user.age)
			}

			if($scope.user.new_email != null){
				$scope.confirm_email = Constants.TRUE;
			}

			if(angular.equals($scope.user.role, Constants.STUDENT))
			{
				$scope.user.class = Constants.FALSE;
				$scope.ui_block();
				apiService.listClass($scope.user.id).success(function(response) {
					$scope.ui_unblock();
					if(angular.equals(response.status, Constants.STATUS_OK)) {
						if(response.errors) {
							$scope.errorHandler(response.errors);
						} else if(response.data){
							if(response.data.records.length) {
								if($scope.user != null){
									$scope.user.class = Constants.TRUE;
								}
							}
						}

						if($scope.user){
							$scope.getUserPoints();
							$scope.updateUserData($scope.user);
						}
					}

				}).error(function(response) {
					$scope.internalError();
				});
			}
		}
	}

	$scope.checkClassRecord = function(SuccessCallback) {

		if(angular.equals($scope.user.role, Constants.STUDENT)) {
			apiService.listClass($scope.user.id).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						$scope.errorHandler(response.errors);
					} else if(response.data){
						SuccessCallback(response.data);
					}
				}
			}).error(function(response){
				$scope.internalError();
			});
		}

	}

	$scope.getUserPoints = function() {
		var id = $scope.user.id;
		var user = $("input[name='userdata']").val();
		$scope.user = JSON.parse(user);

		apiService.getUserPoints(id).success(function(response){
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					if($scope.user){
						$scope.user.points = response.data.reward_points;
						$scope.user.cash_points = response.data.cash_points;
					}
				}
			}

			$scope.updateUserData($scope.user);
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	function showModal(id) {
		$scope.show_terms = (id == 'terms_modal') ? Constants.TRUE : Constants.FALSE;
		$scope.show_policy = (id == 'policy_modal') ? Constants.TRUE : Constants.FALSE;
		$scope.show = Constants.TRUE;


		$("#"+id).modal({
				backdrop: 'static',
				keyboard: Constants.FALSE,
				show    : Constants.TRUE
		});
	}

	function getAvatarImages(change) {
		if(change || $scope.user.avatar_id == null || $scope.user.avatar_id == "") {
			apiService.getAvatarImages($scope.user.gender).success(function(response) {
				if(response.status == Constants.STATUS_OK) {
					if(response.errors) {
						$scope.errorHandler(response.errors);
					} else if(response.data){
						$scope.avatars = response.data;
					}
				}
			}).error(function(response) {
				$scope.internalError();
			});
		} else {
			$scope.has_avatar = Constants.TRUE;
		}
	}

	function highlightAvatar(e) {
		var target = getTarget(e);

		$("ul.avatar_list li").removeClass('selected');
		$(target).addClass('selected');
		$scope.avatar_id = $(target).find("#avatar_id").val(); 
		$scope.enable = Constants.TRUE;
	}

	function selectAvatar() {
		$scope.ui_block();
		apiService.selectAvatar($scope.user.id, $scope.avatar_id).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					$scope.errorHandler(response.errors);
				} else if(response.data){
					$scope.user.avatar_id = response.data.id;
					$scope.user.avatar = response.data.url;

					$scope.session_user = $scope.user;
					$scope.has_avatar = Constants.TRUE;
					apiService.updateUserSession($scope.user).success(function(response) {
						$("ul.avatar_list li").removeClass('selected');
						window.location.href = '/student/dashboard';
					}).error(function() {
						$scope.internalError();
					});
				}
			}
			$scope.ui_unblock();
		}).error(function(response) {
			$scope.internalError();
		});
	}

	function getImagePassword() {
		apiService.getImagePassword().success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					$scope.errorHandler(response.errors);
				} else if(response.data) {
					$scope.image_pass = response.data;
				}
			}
		}).error(function(response) {
			$scope.internalError();
		});
	}
	/**
	* End of Student Page Functions
	*/

	/**
	* Get announcement
	*/
	$scope.getAnnouncement = function(){
		apiService.getAnnouncement().success(function(response){
				if(angular.equals(response.status, Constants.STATUS_OK)){
					if(!isDataEmpty(response.data)){
						$scope.announce = response.data;
					}
				}
		}).error(function(response){
				$scope.internalError();
		});
	}

	$scope.setCountryGrade = setCountryGrade;
	function setCountryGrade() {
	  	// Set Grade Code to empty string
	  	$scope.grade_code = Constants.EMPTY_STR;
	  	$scope.getGradeLevel($scope.reg.country_id);

	  	// Get Country details, set country name
	  	$scope.country = Constants.EMPTY_STR;
		apiService.getCountryDetails($scope.reg.country_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					$scope.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(response.data.length) {
						$scope.country = response.data[0].name;
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	  }

	  $scope.backgroundClass = backgroundClass;
	  function backgroundClass() {
	  	$scope.backgroundChange = Constants.TRUE;
	  }

	  $scope.checkClass = function(flag) {
		$scope.ui_block();

		apiService.checkClass($scope.user.id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
					if(response.errors) {
						if(response.errors[0]){
							if(flag == 1){
								$window.location.href = '/student';
							}
							$scope.no_class = Constants.TRUE;
							$("#error_class_modal").modal({
						        backdrop: 'static',
						        keyboard: Constants.FALSE,
						        show    : Constants.TRUE
						    });
						}
					}else if(response.data == Constants.FALSE){
						if(flag == 1){
							$window.location.href = '/student';
						}
						$scope.no_class = Constants.TRUE;
						$("#error_class_modal").modal({
					        backdrop: 'static',
					        keyboard: Constants.FALSE,
					        show    : Constants.TRUE
					    });
					}else{
						if(flag == 1){
							$scope.ui_unblock();
						} else{
							$window.location.href = '/student/class';
						}
					}
				}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		});
	}

	$scope.getStudentBadges = function() {
		var id = $scope.user.id;

		apiService.getStudentBadges(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					$scope.errorHandler(response.errors);
				} else if(response.data) {
					$scope.badges = response.data;
				}
			}
		}).error(function(response) {
			$scope.internalError()
		});
	}

	$scope.checkLearningStyle = function() {
		var lsp_url = Constants.LSP_URL;
		var current_url = window.location.pathname;

		if($scope.user){
			var lsp_id = parseInt($scope.user.learning_style_id);
			if(lsp_url != current_url){
				if(!lsp_id && $scope.user.checked != Constants.TRUE){
					$scope.user.checked = Constants.TRUE;
					apiService.updateUserSession($scope.user).success(function(response) {
						window.location.href = '/student/dashboard/follow-up-registration';
					}).error(function() {
						$scope.internalError();
					});
				}
			}
		}
	}

	$scope.resetChecked = function() {
		
		$scope.user.checked = Constants.FALSE;
		apiService.updateUserSession($scope.user).success(function(response) {
			
		}).error(function() {
			$scope.internalError();
		});
			
	}

	$scope.updateUserData = function(data) {
		$scope.user = data;
		$("input[name='userdata'").val(JSON.stringify($scope.user));

		apiService.updateUserSession($scope.user);
	}

	$scope.checkLSP = function (user) {

		apiService.studentLearningStyle(user).success(function (response) {

			if (response.data.learning_style == Constants.FALSE) {
				$scope.user.take_lsp = Constants.FALSE;
				$scope.updateUserData($scope.user);

			} else {
				$scope.user.take_lsp = Constants.TRUE;
				window.location.href = '/student/learning-style';
			}

		}).error(function () {
			$scope.internalError();
		});
	}
	
};