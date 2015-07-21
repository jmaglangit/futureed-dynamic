angular.module('futureed.services')
	.factory('ManageHelpRequestService', ManageHelpRequestService);

ManageHelpRequestService.$inject = ['$http'];

function ManageHelpRequestService($http) {
	var service = {};
	var serviceUrl = '/api/v1/';

	service.list = function list(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : serviceUrl + 'help-request?module=' + search.module
				+ '&subject=' + search.subject
				+ '&subject_area=' + search.subject_area
				+ '&status=' + search.request_status
				+ '&title=' + search.title
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	service.detail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : serviceUrl + 'help-request/' + id
		});
	}

	service.update = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data	: data
			, url   : serviceUrl + 'help-request/' + data.id
		});
	}

	service.delete = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url   : serviceUrl + 'help-request/' + id
		});
	}

	service.updateHelpStatus = function(data) {
		return $http({
			method 	: Constants.METHOD_PATCH
			, url   : serviceUrl + 'help-request/update-request-status/' + data.id + "?request_status=" + data.request_status
		});
	}

	return service;
}