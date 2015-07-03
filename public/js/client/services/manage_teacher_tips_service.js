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

	return teacherTipsApi;
}