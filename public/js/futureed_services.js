var services = angular.module('futureed.services', ['ngResource']);

	services.factory('futureedAPIservice', function($http) {
		var futureedAPI = {};
		var futureedAPIUrl = '/api/v1/';
	/*
		
		futureEdAPI.getDrivers = function() {
			return $http({
			method: 'JSONP', 
			url: 'http://ergast.com/api/f1/2013/driverStandings.json?callback=JSON_CALLBACK'
			});
		}
		
	*/
		
		return futureEdAPI;
	});

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

		loginAPI.getImagePassword = function(user_id) {
			return $http({
				method	: 'POST'
				, data	: {user_id : user_id}
				, url	: futureedAPIUrl + 'student/login/image'
			});
		}

		loginAPI.validatePassword = function(id, image_id) {
			return $http({
				method	: 'POST'
				, data	: {user_id : id, image_id : image_id}
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
				, url	: futureedAPIUrl + 'user/password/code'
			});
		}

		return loginAPI;
	});