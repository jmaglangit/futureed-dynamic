angular.module('futureed.services')
	.factory('ManageLogsService', ManageLogsService);

ManageLogsService.$inject = ['$http'];

function ManageLogsService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.list = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : apiUrl + 'logs/users?user_id=' + search.user_id
				+ '&username=' + search.username
				+ '&email=' + search.email
				+ '&name=' + search.name
				+ '&user_type=' + search.user_type
				+ '&page_accessed=' + search.page_accessed
				+ '&api_accessed=' + search.api_accessed
				+ '&result_response=' + search.result_response
				+ '&status=' + search.status
				+ '&date_start=' + search.date_start
				+ '&date_end=' + search.date_end
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	return api;
}