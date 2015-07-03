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

	return teacherTipsApi;
}