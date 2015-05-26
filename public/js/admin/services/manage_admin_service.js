angular.module('futureed.services')
	.factory('manageAdminService', manageAdminService);

function manageAdminService($http) {
	var adminApiUrl = '/api/v1/';
	var manageAdminApi = {};

	manageAdminApi.getAdminList = getAdminList;

	function getAdminList(){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'admin'
		});
	}

	return manageAdminApi;
}