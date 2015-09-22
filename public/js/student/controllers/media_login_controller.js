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
				var birth_date = $filter(Constants.DATE)(new Date(response.birthday), Constants.DATE_YYYYMMDD);

				// TODO: API call to save info
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