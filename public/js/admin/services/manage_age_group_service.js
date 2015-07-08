angular.module('futureed.services')
	.factory('ManageAgeGroupService', ManageAgeGroupService);

ManageAgeGroupService.$inject = ['$http'];

function ManageAgeGroupService($http) {
	var ageGroupServiceApi = {};
	var ageGroupServiceUrl = '/api/v1/';

	ageGroupServiceApi.getAge = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: ageGroupServiceUrl + 'age-group'
		});
	}

	ageGroupServiceApi.addAgeGroup = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: ageGroupServiceUrl + 'module-group'
		});
	}

	return ageGroupServiceApi;

}
