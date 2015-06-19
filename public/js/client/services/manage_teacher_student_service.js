angular.module('futureed.services')
	.factory('ManageTeacherStudentService', ManageTeacherStudentService);

ManageTeacherStudentService.$inject = ['$http'];

function ManageTeacherStudentService($http){
	var manageTeacherStudentApi = {};
	var teacherStudentApiUrl = '/api/v1/';

	manageTeacherStudentApi.getStudentlist = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: teacherStudentApiUrl + 'client/manage/student?name=' + search.name
				+ '&email=' + search.email
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}
	
	
	return manageTeacherStudentApi;
}