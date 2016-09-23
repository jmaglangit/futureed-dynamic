angular.module('futureed.services')
	.factory('manageClientService', manageClientService);

manageClientService.$inject = ['$http'];

function manageClientService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.getClientList = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'client?name=' + search.name
				+ "&email=" + search.email
				+ "&school=" + search.school
				+ "&client_role=" + search.client_role
				+ "&limit=" + table.size
				+ "&offset=" + table.offset
		});
	}

	/**
	* Get Client Details  
	*
	* @Param
	*		id 	- [Required] the client id
	*/
	api.getClientDetails = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'client/admin/' + id
		});
	}

	/**
	* Reject Client Registration
	*
	* @Params
	*		id 				- [Required] the client id
	*		callback_uri 	- [Required] the callback uri, link to register
	*/
	api.rejectClient = function(id, callback_uri) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: {account_status : "Rejected", callback_uri : callback_uri}
			, url 	: apiUrl + 'client/reject-client/' + id
		});
	}

	/**
	* Verify Client Registration  
	*
	* @Params
	*		id 				- [Required] the client id
	*		callback_uri 	- [Required] the callback uri, link to login
	*/
	api.verifyClient = function(id, callback_uri) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: {account_status : "Accepted", callback_uri : callback_uri}
			, url 	: apiUrl + 'client/verify-client/' + id
		});
	}

	/**
	* Update Client Details 
	*
	* @Param
	*		data 			- [Required] the updated client data
	*/
	api.updateClientDetails = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data	: data
			, url 	: apiUrl + 'client/' + data.id
		});
	}

	/**
	* Change Client Status
	*
	* @Params
	*		id 				- [Required] the client id
	* 		status 			- [Required] the client status, Enable / Disable
	*/
	api.clientChangeStatus = function(id, status) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: {status : status}
			, url 	: apiUrl + 'client/change-status/' + id
		});
	}

	/**
	* Create New Client 
	*
	* @Param
	*		data 			- [Required] the client data
	*/
	api.add = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: data
			, url 	: apiUrl + 'client'
		});
	}

	/**
	* Search School
	*
	* @Param
	*		school_name		- [Optiona] the school name
	*/
	api.searchSchool = function(school_name) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'school/search?school_name=' + school_name
		});
	}

	/**
	* @Param
	*	id - client id to be deleted
	*/
	api.deleteModeClient = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: apiUrl + 'client/' + id
		});
	}

	api.impersonate = function(data) {
		return $http({
			method	: Constants.METHOD_POST
			, data	: data
			, url 	: apiUrl + 'admin/impersonate/login'
		});
	}

	//download student template
	api.downloadTemplate = function(file){
		return $http({
			method	:	Constants.METHOD_GET
			,url	:	'/downloads/' + file
		});
	}

	//import student template
	api.importClient = function(data){
		return $http({
			method	:	Constants.METHOD_POST
			,data	:	data
			,url	:	apiUrl + '/client/import'
		});
	}

	return api;
}