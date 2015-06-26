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
				+ '&client_id=' + search.client_id
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

	api.updateDetails = function(data) {
		return $http({
			method : Constants.METHOD_PUT
			, data : data
			, url  : apiUrl + 'client/manage/student/' + data.id 
		});
	}

	api.updateEmail = function(data) {
		return $http({
			method : Constants.METHOD_PUT
			, data : data
			, url  : apiUrl + 'client/manage/email/student/' + data.student_id 
		});
	}
	
	return api;
}