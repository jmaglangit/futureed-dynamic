angular.module('futureed.services')
	.factory('manageTeacherStudentService', ManageTeacherStudentService);

ManageTeacherStudentService.$inject = ['$http'];

function ManageTeacherStudentService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.listStudent = function(search, table) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'client/manage/student?client_role=' + search.client_role
				+ '&name=' + search.name
				+ '&email=' + search.email
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	api.studentDetails = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'client/manage/student/' + id 
		});
	}
	
	return api;
}