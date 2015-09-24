angular.module('futureed.services')
	.factory('StudentLoginService', StudentLoginService);

StudentLoginService.$inject = ['$http'];

function StudentLoginService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.registerFB = function(data) {
		return $http({
			  method 	: Constants.METHOD_POST
			, data 		: data 
			, url		: apiUrl + 'registration/facebook'
		});
	}

	api.registerGoogle = function(data) {
		return $http({
			  method 	: Constants.METHOD_POST
			, data 		: data
			, url		: apiUrl + 'registration/google'
		});
	}

	api.loginFacebook = function(data) {
		return $http({
			  method 	: Constants.METHOD_POST
			, data 		: data
			, url		: apiUrl + 'login/facebook'
		});
	}

	api.loginGoogle = function(data) {
		return $http({
			  method 	: Constants.METHOD_POST
			, data 		: data
			, url		: apiUrl + 'login/google'
		});
	}

	return api;
}