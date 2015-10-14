angular.module('futureed.services')
	.factory('ManageLogsService', ManageLogsService);

ManageLogsService.$inject = ['$http'];

function ManageLogsService($http) {
	var api = {};
	var apiUrl = '/api/log/';

	api.securityLogs = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : apiUrl + 'security?username=' + search.username
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
			, url   : apiUrl + 'admin?username=' + search.username
				+ '&email=' + search.email
				+ '&name=' + search.name
				+ '&result_response=' + search.result_response
				+ '&admin_type=' + search.admin_type
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	api.userLogs = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : apiUrl + 'user?username=' + search.username
				+ '&user_type=' + search.user_type
				+ '&result_response=' + search.result_response
				+ '&api_accessed=' + search.api_accessed
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	api.systemLogs = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : apiUrl + 'system'
		});
	}

	api.downloadSystemLog = function(filename) {
		return apiUrl + 'system/' + filename;
	}

	api.errorLogs = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : apiUrl + 'error'
		});
	}

	api.downloadErrorLog = function(filename) {
		return apiUrl + 'error/' + filename;
	}

	return api;
}