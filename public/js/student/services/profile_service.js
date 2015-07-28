angular.module('futureed.services')
	.factory('profileService', profileService);

profileService.$inject = ['$http'];

function profileService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	/**
	* Common API Calls
	*/

	api.getCountryDetails = function(id) {
		return $http({
			  method 	: Constants.METHOD_GET
			, url	: apiUrl + 'countries/' + id
		});
	}

	api.getBadges = function(id) {
		return $http({
			  method 	: Constants.METHOD_GET
			, url	: apiUrl + 'badge/student?student_id=' + id
		});
	}

	return api;
}