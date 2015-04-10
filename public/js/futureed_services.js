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
				// , url 	: 'http://dev.futureed.nerubia.com/api/v1/student/login/username'
				, url	: 'http://localhost:80/api/v1/student/login/username'
			});
		}

		loginAPI.validatePassword = function(user_id) {
			return $http({
				method	: 'POST'
				, data	: {user_id : user_id}
				, url	: 'http://dev.futureed.nerubia.com/api/v1/student/login/image'
			});
		}

		return loginAPI;
	});

	services.factory('loginAPIService2',function($resource) {
		return $resource("http://dev.futureed.nerubia.com/api/v1/student/login/username", null, {
			'validateUser': { method: 'GET', url: "http://dev.futureed.nerubia.com/api/v1/countries" }
		});
	});