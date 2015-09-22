angular.module('futureed.controllers')
	.controller('MediaLoginController', MediaLoginController);

MediaLoginController.$inject = ['$scope', '$filter', '$window', 'MediaLoginService'];

function MediaLoginController($scope, $filter, $window, MediaLoginService) {
	var self = this;

	/**
	* Facebook Login for AngularJS
	*/

	// Initialize FB API on load
	$window.fbAsyncInit = function() {
	    FB.init({ 
	      appId: Constants.DI_PPA_BF
	      , status: true 
	      , xfbml: true
	      , version: 'v2.3'
	    });
	};

	self.logoutFacebook = function() {
		FB.logout();
	}

	self.loginViaFacebook = function() {
		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				fbLoginCallback(response);
			} else {
				var fbOptions = {
					scope : 'email, public_profile, user_birthday, user_location'
				}

				FB.login(fbLoginCallback, fbOptions);
			}
		});
	}

	var fbLoginCallback = function(response) {
		if (response.authResponse) {
			FB.api('/' + response.authResponse.userID, {fields: 'email, first_name, last_name, gender, birthday, location'}, function(response) {
				var fb_data = response;
				var birth_date = $filter(Constants.DATE)(new Date(fb_data.birthday), Constants.DATE_YYYYMMDD);

				var data = {
					facebook_app_id		: fb_data.id
					, email				: fb_data.email
					, user_type			: Constants.STUDENT
					, first_name		: fb_data.first_name
					, last_name			: fb_data.last_name
					, gender			: fb_data.gender
					, birth_date		: birth_date
				}

				$scope.ui_block();
				MediaLoginService.saveFB(data).success(function(response) {
					if(angular.equals(response.status, Constants.STATUS_OK)) {
						if(response.errors) {
							$scope.errorHandler(response.errors);
						} else if(response.data){
							$scope.user = JSON.stringify(response.data);
							$("input[name='user_data']").val(JSON.stringify(response.data));
							$("#media_form").submit();
						} 
					}

					$scope.ui_unblock();
				}).error(function(response) {
					$scope.internalError();
					$scope.ui_unblock();
				});
			});
		}
	}

	self.googleInit = function() {
		gapi.load('auth2', function(){
			var auth2 = gapi.auth2.init({
				client_id: Constants.DI_TNEILC_ELGOOG
				, cookie_policy : 'none'
				, scope : 'https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/plus.login'
			});

			auth2.attachClickHandler('btn-google', auth2, function(response) {
				console.log("Google success...");

				var profile = auth2.currentUser.get();
					console.log(profile.getGrantedScopes());
					
				gapi.client.request({
					  'path'		: 'https://www.googleapis.com/plus/v1/people/me'
					, 'method'		: Constants.METHOD_GET
					, 'callback'	: callback
				});

				var callback = function(response) {
					console.log(response);
				}

			}, function(response) {
				console.log("Google failure...");
				var authInstance = gapi.auth2.getAuthInstance();
				console.log(authInstance);
				console.log(authInstance.signOut());
			});
		});
	}
}