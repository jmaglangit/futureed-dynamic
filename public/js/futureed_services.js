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

		loginAPI.validateUser = function(username) {
			return $http({
				method 	: 'POST'
				, data	: {username : username}
				, url	: '/api/v1/student/login/username'
			});
		}

		loginAPI.getImagePassword = function(user_id) {
			return $http({
				method	: 'POST'
				, data	: {user_id : user_id}
				, url	: 'http://localhost:80/api/v1/student/login/image'
			});
		}

		loginAPI.forgotPassword = function(username) {
			return $http({
				method 	: 'POST'
				, data	: {username: username, user_type : "Student"}
				, url	: 'http://localhost:80/api/v1/user/password/forgot'
			});
		}

		loginAPI.validateCode = function(code, email) {
			return $http({
				method	: 'POST'
				, data 	: {email : email, reset_code : code}
				, url	: 'http://localhost:80/api/v1/user/password/code'
			});
		}

		return loginAPI;
	});