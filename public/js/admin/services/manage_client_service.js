angular.module('futureed.services')
	.factory('manageClientService', manageClientService);

manageClientService.$inject = ['$http'];

function manageClientService($http) {
	var manageClientApi = {};
	var manageClientApiUrl = '/api/v1/';

	/**
	* Get Client List 
	*
	* @Params
	*		search_name 		- [Optional] the client name
	*		search_email		- [Optional] the client email
	*		search_school		- [Optional] the school code
	*		search_client_role 	- [Optional] the client role
	*/
	manageClientApi.getClientList = function(search_name, search_email, search_school, search_client_role) {
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
	manageClientApi.getClientDetails = function(id) {
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
	manageClientApi.rejectClient = function(id, callback_uri) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: {account_status : "Rejected", callback_uri : callback_uri}
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
	manageClientApi.verifyClient = function(id, callback_uri) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: {account_status : "Accepted", callback_uri : callback_uri}
			, url 	: manageClientApiUrl + 'client/verify-client/' + id
		});
	}

	/**
	* Update Client Details 
	*
	* @Param
	*		data 			- [Required] the updated client data
	*/
	manageClientApi.updateClientDetails = function(data) {
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
	manageClientApi.clientChangeStatus = function(id, status) {
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
	manageClientApi.createNewClient = function(data) {
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
	manageClientApi.searchSchool = function(school_name) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: manageClientApiUrl + 'school/search?school_name=' + school_name
		});
	}

	return manageClientApi;
}