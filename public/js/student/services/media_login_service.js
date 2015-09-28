angular.module('futureed.services')
	.factory('MediaLoginService', MediaLoginService);

MediaLoginService.$inject = ['$http'];

function MediaLoginService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.registerMedia = function(data, type) {
		return $http({
			  method 	: Constants.METHOD_POST
			, data 		: data 
			, url		: apiUrl + 'registration/' + type
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

	api.getGoogleDetails = function(data) {
		return $http({
			  method 	: Constants.METHOD_GET
			, data 		: data
			, url		: 'https://www.googleapis.com/oauth2/v1/userinfo'
		});
	}

	return api;
}