angular.module('futureed.services')
	.factory('manageClientService', manageClientService);


function manageClientService($http) {

	var manageClientApi = {};
	var manageClientApiUrl = '/api/v1/';

	manageClientApi.getClientList = getClientList;
	manageClientApi.getClientDetails = getClientDetails;
	manageClientApi.updateClientDetails = updateClientDetails;
	manageClientApi.clientChangeStatus = clientChangeStatus;
	manageClientApi.createNewClient = createNewClient;
	manageClientApi.searchSchool = searchSchool;

	function getClientList(search_name, search_email, search_school, search_client_role) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: manageClientApiUrl + 'client?name=' + search_name
				+ "&email=" + search_email
				+ "&school_code=" + search_school
				+ "&client_role=" + search_client_role
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

	function clientChangeStatus(id, status) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: {status : status}
			, url 	: manageClientApiUrl + 'client/change-status/' + id
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