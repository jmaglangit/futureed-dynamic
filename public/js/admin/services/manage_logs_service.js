angular.module('futureed.services')
	.factory('ManageLogsService', ManageLogsService);

ManageLogsService.$inject = ['$http'];

function ManageLogsService($http) {
	var api = {};
	var apiUrl = '/api/';

	api.securityLogs = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : apiUrl + 'log/security?username=' + search.username
				+ '&client_user_agent=' + search.client_user_agent
				+ '&result_response=' + search.result_response
				+ '&log_type=' + search.log_type
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	api.adminLogs = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : apiUrl + 'log/admin?username=' + search.username
				+ '&email=' + search.email
				+ '&name=' + search.name
				+ '&result_response=' + search.result_response
				+ '&admin_type=' + search.admin_type
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	return api;
}