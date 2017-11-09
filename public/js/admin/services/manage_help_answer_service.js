angular.module('futureed.services')
	.factory('ManageHelpAnswerService', ManageHelpAnswerService);

ManageHelpAnswerService.$inject = ['$http'];

function ManageHelpAnswerService($http) {
	var service = {};
	var serviceUrl = '/api/v1/';

	service.list = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : serviceUrl + 'help-request-answer?help_request=' + search.help_request
				+ '&request_answer_status=' + search.request_answer_status
				+ '&module=' + search.module
				+ '&subject_area=' + search.subject_area
				+ '&subject=' + search.subject
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	service.detail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url   : serviceUrl + 'help-request-answer/' + id
		});
	}

	service.update = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data	: data
			, url   : serviceUrl + 'help-request-answer/' + data.id
		});
	}

	service.delete = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url   : serviceUrl + 'help-request-answer/' + id
		});
	}

	service.updateHelpAnswerStatus = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data  : data
			, url   : serviceUrl + 'help-request-answer/status/' + data.id
		});
	}

	return service;
}