angular.module('futureed.services')
	.factory('ManageTeacherAnswerService', ManageTeacherAnswerService);

function ManageTeacherAnswerService($http){
	var url = '/api/v1/';
	var service = {};

	service.listAnswer = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: url + 'help-request-answer?class_id=' + search.class_id 
				+ '&help_request=' + search.title
				+ '&request_answer_status=' + search.status
				+ '&created_by=' + search.created
				+ '&subject=' + search.subject
				+ '&area=' + search.area
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	service.detail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			,url 	: url + 'help-request-answer/' + id
		});
	}

	service.update = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			,data 	: data
			, url 	: url + 'help-request-answer/' + data.id
		});
	}

	service.updateStatus = function(id, status) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {request_answer_status : status}
			, url 	: url + 'help-request-answer/status/' + id
		});
	}

	return service;
}