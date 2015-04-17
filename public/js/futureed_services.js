var services = angular.module('futureed.services', ['ngResource']);

	services.factory('loginAPIService', function($http) {
		
		var loginAPI = {};
		var futureedAPIUrl = '/api/v1/';

		loginAPI.validateUser = function(username) {
			return $http({
				method 	: 'POST'
				, data	: {username : username}
				, url	: futureedAPIUrl + 'student/login/username'
			});
		}

		loginAPI.getImagePassword = function(id) {
			return $http({
				method	: 'POST'
				, data	: {id : id}
				, url	: futureedAPIUrl + 'student/login/image'
			});
		}

		loginAPI.validatePassword = function(id, image_id) {
			return $http({
				method	: 'POST'
				, data	: {id : id, image_id : image_id}
				, url	: futureedAPIUrl + 'student/login/password'
			});
		}

		loginAPI.forgotPassword = function(username) {
			return $http({
				method 	: 'POST'
				, data	: {username: username, user_type : "Student"}
				, url	: futureedAPIUrl + 'user/password/forgot'
			});
		}

		loginAPI.validateCode = function(code, email) {
			return $http({
				method	: 'POST'
				, data 	: {email : email, reset_code : code}
				, url	: futureedAPIUrl + 'student/password/code'
			});
		}

		loginAPI.resetPassword = function (id, code, image_id) {
			return $http({
				method	: 'POST'
				, data	: {id : id, reset_code : code, password_image_id : image_id}
				, url	: futureedAPIUrl + 'student/password/reset'
			});
		}

		loginAPI.validateRegistration = function(registration) {
			return $http({
				method	: 'POST'
				, data	: registration
				, url	: futureedAPIUrl + 'student/register'
			});
		}

		loginAPI.getAvatarImages = function(gender) {
			return $http({
				method	: 'POST'
				, data	: {gender : gender}
				, url	: futureedAPIUrl + 'user/avatar'
			});
		}

		loginAPI.selectAvatar = function(id, avatar_id) {
			return $http({
				method	: 'POST'
				, data	: {user_id : id, avatar_id : avatar_id}
				, url	: futureedAPIUrl + 'user/avatar/new'
			});
		}

		return loginAPI;
	});