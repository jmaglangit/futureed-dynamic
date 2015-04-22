var services = angular.module('futureed.services', ['ngResource']);

	services.factory('loginAPIService', function($http) {
		
		var futureedAPI = {};
		var futureedAPIUrl = '/api/v1/';

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

		futureedAPI.forgotPassword = function(username) {
			return $http({
				method 	: 'POST'
				, data	: {username: username, user_type : "Student"}
				, url	: futureedAPIUrl + 'user/password/forgot'
			});
		}

		futureedAPI.validateCode = function(code, email) {
			return $http({
				method	: 'POST'
				, data 	: {email : email, user_type : "Student", reset_code : code}
				, url	: futureedAPIUrl + 'student/password/code'
			});
		}

		futureedAPI.confirmCode = function(code, email) {
			return $http({
				method	: 'POST'
				, data 	: {email : email, user_type : "Student", email_code : code}
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

		futureedAPI.validateUsername = function(username) {
			return $http({
				method 	: 'POST'
				, data 	: {username : username, user_type : "Student"}
				, url 	: futureedAPIUrl + 'user/username'
			});
		}

		futureedAPI.validateEmail = function(email) {
			return $http({
				method	: 'POST'
				, data 	: {email : email, user_type : "Student"}
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
	      // optional method
	      'response': function(response) {
	        // do something on success
	        $("html, body").animate({ scrollTop: 0 }, "slow");
	        return response;
	      },

	      // optional method
	     'responseError': function(rejection) {
	        // do something on error
	        $("html, body").animate({ scrollTop: 0 }, "slow");
	        return $q.reject(rejection);
	      }
	    };
	  });