var services = angular.module('futureed.services', ['ngResource']);

	services.factory('apiService', function($http) {
		
		var futureedAPI = {};
		var futureedAPIUrl = '/api/v1/';

		futureedAPI.clientLogin = clientLogin;
		futureedAPI.registerClient = registerClient;
		futureedAPI.resetClientPassword = resetClientPassword;

		function clientLogin(username, password, role) {
			return $http({
				method	: 'POST'
				, data 	: {username : username, password : password, role : role}
				, url	: futureedAPIUrl + 'client/login'
			});
		}

		function registerClient(data) {
			return $http({
				method	: 'POST'
				, data	: data
				, url 	: futureedAPIUrl + 'client/register'
			});
		}

		function resetClientPassword(id, reset_code, password) {
			return $http({
				method 	: 'POST'
				, data 	: {reset_code : reset_code, password : password}
				, url	: futureedAPIUrl + 'client/password/' + id
			});
		}


		/**
		* Student Services
		*/

		futureedAPI.resendConfirmation = resendConfirmation;

		function resendConfirmation(email, user_type) {
			return $http({
				method	: 'POST'
				, data 	: {email : email, user_type : user_type}
				, url	: futureedAPIUrl + 'user/confirmation/code'
			});
		}

		futureedAPI.updateUserSession = function(user) {
			return $http({
				method	: 'POST',
				data 	: user,
				url		: '/student/update-user-session'
			});
		}

		futureedAPI.validateUser = function(username) {
			return $http({
				method 	: 'POST'
				, data	: { username : username } 
				, url	: futureedAPIUrl + 'student/login/username'
			});
		}

		futureedAPI.getLoginPassword = function(id) {
			return $http({
				method	: 'POST'
				, data	: {id : id}
				, url	: futureedAPIUrl + 'student/login/image'
			});
		}

		futureedAPI.getImagePassword = function() {
			return $http({
				method	: 'GET'
				, url	: futureedAPIUrl + 'student/password/image'
			});
		}

		futureedAPI.validatePassword = function(id, image_id) {
			return $http({
				method	: 'POST'
				, data	: {id : id, image_id : image_id}
				, url	: futureedAPIUrl + 'student/login/password'
			});
		}

		futureedAPI.forgotPassword = function(username, user_type) {
			return $http({
				method 	: 'POST'
				, data	: {username: username, user_type : user_type}
				, url	: futureedAPIUrl + 'user/password/forgot'
			});
		}

		futureedAPI.validateCode = function(code, email, user_type) {
			return $http({
				method	: 'POST'
				, data 	: {email : email, user_type : user_type, reset_code : code}
				, url	: futureedAPIUrl + 'user/password/code'
			});
		}

		// Student Please
		futureedAPI.confirmCode = function(email, email_code, user_type) {
			return $http({
				method	: 'POST'
				, data 	: {email : email, email_code : email_code, user_type : user_type}
				, url	: futureedAPIUrl + 'user/email/code'
			});
		}

		futureedAPI.resetPassword = function (id, code, image_id) {
			return $http({
				method	: 'POST'
				, data	: {id : id, reset_code : code, password_image_id : image_id}
				, url	: futureedAPIUrl + 'student/password/reset'
			});
		}

		futureedAPI.setPassword = function (id, code, image_id) {
			return $http({
				method	: 'POST'
				, data	: {id : id, email_code : code, password_image_id : image_id}
				, url	: futureedAPIUrl + 'student/password'
			});
		}

		futureedAPI.getCountries = function() {
			return $http({
				method	: 'GET'
				, url	: futureedAPIUrl + 'countries'
			});
		}

		futureedAPI.getGradeLevel =function() {
			return $http({
				method	: 'GET'
				, url	: futureedAPIUrl + 'grade'
			});
		}

		// Student Please
		futureedAPI.validateUsername = function(username, user_type) {
			return $http({
				method 	: 'POST'
				, data 	: {username : username, user_type : user_type}
				, url 	: futureedAPIUrl + 'user/username'
			});
		}

		// Student Please
		futureedAPI.validateEmail = function(email, user_type) {
			return $http({
				method	: 'POST'
				, data 	: {email : email, user_type : user_type}
				, url	: futureedAPIUrl + 'user/email'
			});
		}

		futureedAPI.validateRegistration = function(registration) {
			return $http({
				method	: 'POST'
				, data	: registration
				, url	: futureedAPIUrl + 'student/register'
			});
		}

		futureedAPI.getAvatarImages = function(gender) {
			return $http({
				method	: 'POST'
				, data	: {gender : gender}
				, url	: futureedAPIUrl + 'user/avatar'
			});
		}

		futureedAPI.selectAvatar = function(id, avatar_id) {
			return $http({
				method	: 'POST'
				, data	: {id : id, avatar_id : avatar_id}
				, url	: futureedAPIUrl + 'user/avatar/new'
			});
		}

		/**
		* Profile related calls
		*/
		futureedAPI.studentDetails = function(id, access_token) {
			return $http({
				method 	: 'GET'
				, data 	: {access_token : access_token}
				, url	: futureedAPIUrl + 'student/' + id
			});
		}

		futureedAPI.saveProfile = function(data) {
			return $http.put(futureedAPIUrl + 'student/' + data.id, data);
		}

		futureedAPI.validateCurrentPassword = function(id, password_image_id, access_token) {
			return $http({
				method 	: 'POST'
				, data 	: {password_image_id : password_image_id, access_token : access_token}
				, url 	: futureedAPIUrl + 'student/password/' + id
			});
		}

		futureedAPI.changePassword = function(id, password_image_id, access_token) {
			return $http({
				method	: 'POST'
				, data 	: {password_image_id : password_image_id, access_token : access_token}
				, url 	: futureedAPIUrl + 'student/password/' + id
			});
		}

		return futureedAPI;
	});

	services.factory("httpInterceptor", function($q) {
	    return {
	     'responseError': function(rejection) {
	        $("html, body").animate({ scrollTop: 0 }, "slow");
	        return $q.reject(rejection);
	      }
	    };
	  });