angular.module('futureed.services')
	.factory('manageClientService', manageClientService);


function manageClientService($http) {

	var manageClientApi = {};
	var manageClientApiUrl = '/api/v1/';

	manageClientApi.getClientList = getClientList;
	manageClientApi.getClientDetails = getClientDetails;
	manageClientApi.updateClientDetails = updateClientDetails;
	manageClientApi.createNewClient = createNewClient;
	manageClientApi.searchSchool = searchSchool;

	function getClientList() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: manageClientApiUrl + 'client'
		});
	}

	function getClientDetails(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: manageClientApiUrl + 'client/' + id
		});
	}

	function updateClientDetails(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data	: data
			, url 	: manageClientApiUrl + 'client/' + data.id
		});
	}

	function createNewClient(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: data
			, url 	: manageClientApiUrl + 'client'
		});
	}

	function searchSchool(school_name) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: {school_name : school_name}
			, url 	: manageClientApiUrl + 'school/search'
		});
	}

	return manageClientApi;
}