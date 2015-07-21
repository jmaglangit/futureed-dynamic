angular.module('futureed.services')
	.factory('ManageTeacherTipsService', ManageTeacherTipsService);

function ManageTeacherTipsService($http){
	var tipsApiUrl = '/api/v1/';
	var teacherTipsApi = {};

	teacherTipsApi.list = function(id, search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: tipsApiUrl + 'tip/teacher?class_id=' + id
				+ '&title=' + search.title
				+ '&status=' + search.status
				+ '&created=' + search.created
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	teacherTipsApi.detail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: tipsApiUrl + 'tip/teacher/' + id
		});
	}

	teacherTipsApi.saveEdit = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			, url 	: tipsApiUrl + 'tip/teacher/' + data.id
		});
	}

	teacherTipsApi.updateTips = function(id, status) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: {tip_status : status}
			, url 	: tipsApiUrl + 'tip/update-status/' + id
		});
	}

	teacherTipsApi.listHelp = function(id, search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: tipsApiUrl + 'help-request?class_id=' + id
				+ '&title=' + search.title
				+ '&request_status=' + search.status
				+ '&student=' + search.created
				+ '&subject=' + search.subject
				+ '&area=' + search.area
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	teacherTipsApi.helpDetail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			,url 	: tipsApiUrl + 'help-request/' + id
		});
	}

	teacherTipsApi.saveEditHelp = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			,url 	: tipsApiUrl + 'help-request/' + data.id
		});
	}

	teacherTipsApi.updateHelp = function(id, status) {
		return $http({
			method 	: Constants.METHOD_PATCH
			, url 	: tipsApiUrl + 'help-request/update-request-status/' + id
				+ '?request_status=' + status
		});
	}

	teacherTipsApi.helpAnsList = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: tipsApiUrl + 'help-request-answer?help_request=' + search.title
				+ '&request_answer_status=' + search.status
				+ '&created_by=' + search.created
				+ '&subject=' + search.subject
				+ '&area=' + search.area
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	teacherTipsApi.helpAnsDetail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			,url 	: tipsApiUrl + 'help-request-answer/' + id
		});
	}

	teacherTipsApi.saveEditHelpAns = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			,data 	: data
			, url 	: tipsApiUrl + 'help-request-answer/' + data.id
		});
	}

	teacherTipsApi.updateHelpAns = function(id, status) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {request_answer_status : status}
			, url 	: tipsApiUrl + 'help-request-answer/status/' + id
		});
	}

	return teacherTipsApi;
}