angular.module('futureed.controllers')
	.controller('MediaLoginController', MediaLoginController);

MediaLoginController.$inject = ['$scope', '$filter', '$window', 'MediaLoginService'];

function MediaLoginController($scope, $filter, $window, MediaLoginService) {
	var self = this;

	self.user_type = Constants.FALSE;
	/**
	* Facebook Login for AngularJS
	*/

	self.initMediaIds = function(fb_app_id, gl_client_id) {
		self.DI_PPA_BF = fb_app_id;
		self.DI_TNEILC_ELGOOG = gl_client_id;

		self.fbAsyncInit();
	}

	self.setSetUserType = function(type) {
		self.user_type = type;
	}

	// Initialize FB API on load
	self.fbAsyncInit = function() {
		window.fbAsyncInit = function() {
			FB.init({
				appId: self.DI_PPA_BF
				, status: true
				, xfbml: true
				, version: 'v2.3'
			});
		}
	};

	self.loginViaFacebook = function() {
		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				fbLoginCallback(response);
			} else {
				var fbOptions = {
					scope : 'email, public_profile, user_birthday'
				}

				FB.login(fbLoginCallback, fbOptions);
			}
		});
	}

	var fbLoginCallback = function(response) {
		if (response.authResponse) {
			FB.api('/' + response.authResponse.userID, {fields: 'email, first_name, last_name, gender, birthday'}, function(response) {
				var fb_data = response;
				loginFacebook(fb_data);
			});
		}
	}

	var loginFacebook = function(fb_data) {
		self.errors = Constants.FALSE;

		var data = {
			facebook_app_id		: fb_data.id
			, user_type			: self.user_type
		}

		$scope.ui_block();
		MediaLoginService.loginFacebook(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					if(angular.equals($scope.errors[0], "The selected facebook app id is invalid.")) {
						self.errors = Constants.FALSE;

						data.email = fb_data.email;
						data.first_name = fb_data.first_name;
						data.last_name = fb_data.last_name;
						data.gender = fb_data.gender;
						data.media_type = Constants.FACEBOOK;
						data.birth_date = (fb_data.birthday) ? fb_data.birthday : Constants.EMPTY_STR;;
						data.confirm = Constants.TRUE;

						$scope.$emit('confirm-media', data);
					} else {
						$scope.$emit('media-error', self.errors);
					}
				} else if(response.data) {
					response.data.role = (response.data.client_role) ? response.data.client_role : Constants.STUDENT ;
					response.data.media_login = Constants.TRUE;

					$scope.user = JSON.stringify(response.data);
					$("input[name='user_data']").val(JSON.stringify(response.data));
					$("#process_form").submit();
				} 
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.googleInit = function() {
		gapi.load('auth2', function(){
			var auth2 = gapi.auth2.init({
				client_id: self.DI_TNEILC_ELGOOG
				, cookie_policy : 'none'
				, scope : 'https://www.googleapis.com/auth/plus.me'
			});

			auth2.attachClickHandler('btn-google', auth2, function(response) {
				var profile = auth2.currentUser.get();
				loginGoogle(profile.getBasicProfile());
			}, function(response) {
				var authInstance = gapi.auth2.getAuthInstance();
			});
		});
	}

	self.getGoogleDetails = function(successCallback) {
		gapi.client.request({
			path : 'https://www.googleapis.com/oauth2/v1/userinfo'
		}).execute(function(response) {
			if(successCallback) {
				successCallback(response);
			}
		});
	}

	var loginGoogle = function(google_data) {
		self.errors = Constants.FALSE;

		var data = {
			google_app_id		: google_data.getId()
			, user_type			: self.user_type
		}

		$scope.ui_block();
		MediaLoginService.loginGoogle(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					if(angular.equals($scope.errors[0], "The selected google app id is invalid.")) {
						self.errors = Constants.FALSE;

						var client_data = {
							google_app_id		: google_data.getId()
							, user_type			: Constants.STUDENT
							, email 			: google_data.getEmail()
							, media_type		: Constants.GOOGLE
							, confirm			: Constants.TRUE
							, birth_date		: Constants.EMPTY_STR
						}

						$scope.$emit('confirm-media', client_data);
					}
				} else if(response.data){
					response.data.role = (response.data.client_role) ? response.data.client_role : Constants.STUDENT ;
					response.data.media_login = Constants.TRUE;

					$scope.user = JSON.stringify(response.data);
					$("input[name='user_data']").val(JSON.stringify(response.data));
					$("#process_form").submit();
				} 
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}