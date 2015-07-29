angular.module('futureed.services')
	.factory('LearningStyleService', LearningStyleService);

function LearningStyleService($http) {
	var service = {};
	var serviceUrl = '/api/v1/assess/';

	service.getTest = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'get-test'
		});
	}
	
	return service;
}