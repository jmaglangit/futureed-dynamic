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

	ageGroupServiceApi.getAgeGroupDetail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: ageGroupServiceUrl + 'module-group/' + id
		});
	}

	ageGroupServiceApi.saveAgeGroup  = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			, url 	: ageGroupServiceUrl + 'module-group/' + data.id
		});
	}

	return ageGroupServiceApi;

}
