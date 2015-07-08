angular.module('futureed.services')
	.factory('ManageAgeGroupService', ManageAgeGroupService);

ManageAgeGroupService.$inject = ['$http'];

function ManageAgeGroupService($http) {
	var ageGroupServiceApi = {};
	var ageGroupServiceUrl = '/api/v1/';

	return ageGroupServiceApi;

}
