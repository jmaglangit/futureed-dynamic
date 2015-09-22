angular.module('futureed.services')
	.factory('MediaLoginService', MediaLoginService);

MediaLoginService.$inject = ['$http'];

function MediaLoginService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.saveFB = function(data) {
		return $http({
			  method 	: Constants.METHOD_POST
			, data 		: data 
			, url		: apiUrl + 'registration/facebook'
		});
	}

	api.saveFB = function(data) {
		return $http({
			  method 	: Constants.METHOD_POST
			, data 		: data
			, url		: apiUrl + 'registration/google'
		});
	}

	return api;
}