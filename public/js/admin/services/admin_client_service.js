angular.module('futureed.services')
	.factory('adminClientService', adminClientService);


function adminClientService($http) {

	var adminClientApi = {};
	var adminClientApiUrl = '/api/v1/';

	adminClientApi.createNewClient = createNewClient;

	function createNewClient(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: data
			, url 	: adminClientApiUrl + 'client'
		});
	}

	return adminClientApi;
}