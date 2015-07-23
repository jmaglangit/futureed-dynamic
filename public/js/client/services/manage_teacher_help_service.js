angular.module('futureed.services')
	.factory('ManageTeacherHelpService', ManageTeacherHelpService);

function ManageTeacherHelpService($http){
	var url = '/api/v1/';
	var service = {};

	service.listHelp = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: url + 'help-request?class_id=' + search.class_id
				+ '&title=' + search.title
				+ '&request_status=' + search.request_status
				+ '&student=' + search.created
				+ '&subject=' + search.subject
				+ '&subject_area=' + search.subject_area
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	service.detail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			,url 	: url + 'help-request/' + id
		});
	}

	service.update = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			,url 	: url + 'help-request/' + data.id
		});
	}

	service.updateStatus = function(id, status) {
		return $http({
			method 	: Constants.METHOD_PATCH
			, url 	: url + 'help-request/update-request-status/' + id
				+ '?request_status=' + status
		});
	}

	return service;
}