angular.module('futureed.services')
	.factory('manageClientService', manageClientService);

manageClientService.$inject = ['$http'];

function manageClientService($http) {
	var manageClientApi = {};
	var manageClientApiUrl = '/api/v1/';

	manageClientApi.getClientList = getClientList;

	manageClientApi.getClientDetails = getClientDetails;
	manageClientApi.rejectClient = rejectClient;
	manageClientApi.verifyClient = verifyClient;
	manageClientApi.updateClientDetails = updateClientDetails;
	manageClientApi.clientChangeStatus = clientChangeStatus;

	manageClientApi.createNewClient = createNewClient;
	manageClientApi.searchSchool = searchSchool;

	/**
	* Get Client List 
	*
	* @Params
	*		search_name 		- [Optional] the client name
	*		search_email		- [Optional] the client email
	*		search_school		- [Optional] the school code
	*		search_client_role 	- [Optional] the client role
	*/
	function getClientList(search_name, search_email, search_school, search_client_role) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: manageClientApiUrl + 'client?name=' + search_name
				+ "&email=" + search_email
				+ "&school_code=" + search_school
				+ "&client_role=" + search_client_role
		});
	}

	/**
	* Get Client Details  
	*
	* @Param
	*		id 	- [Required] the client id
	*/
	function getClientDetails(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: manageClientApiUrl + 'client/' + id
		});
	}

	/**
	* Reject Client Registration
	*
	* @Params
	*		id 				- [Required] the client id
	*		callback_uri 	- [Required] the callback uri, link to register
	*/
	function rejectClient(id, callback_uri) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: {is_account_reviewed : -1, callback_uri : callback_uri}
			, url 	: manageClientApiUrl + 'client/reject-client/' + id
		});
	}

	/**
	* Verify Client Registration  
	*
	* @Params
	*		id 				- [Required] the client id
	*		callback_uri 	- [Required] the callback uri, link to login
	*/
	function verifyClient(id, callback_uri) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: {is_account_reviewed : Constants.TRUE, callback_uri : callback_uri}
			, url 	: manageClientApiUrl + 'client/verify-client/' + id
		});
	}

	/**
	* Update Client Details 
	*
	* @Param
	*		data 			- [Required] the updated client data
	*/
	function updateClientDetails(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data	: data
			, url 	: manageClientApiUrl + 'client/' + data.id
		});
	}

	/**
	* Change Client Status
	*
	* @Params
	*		id 				- [Required] the client id
	* 		status 			- [Required] the client status, Enable / Disable
	*/
	function clientChangeStatus(id, status) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: {status : status}
			, url 	: manageClientApiUrl + 'client/change-status/' + id
		});
	}

	/**
	* Create New Client 
	*
	* @Param
	*		data 			- [Required] the client data
	*/
	function createNewClient(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: data
			, url 	: manageClientApiUrl + 'client'
		});
	}

	/**
	* Search School
	*
	* @Param
	*		school_name		- [Optiona] the school name
	*/
	function searchSchool(school_name) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: {school_name : school_name}
			, url 	: manageClientApiUrl + 'school/search'
		});
	}

	return manageClientApi;
}