angular.module('futureed.services')
	.factory('ManageParentStudentService', ManageParentStudentService);

function ManageParentStudentService($http){
	var studentApiUrl = '/api/v1/';
	var manageStudentApi = {};
	
	manageStudentApi.getStudentlist = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: studentApiUrl + 'client/manage/student?name=' + search.name
				+ '&email=' + search.email
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	manageStudentApi.addExist = function(email, id) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {email : email, client_id : id}
			, url 	: studentApiUrl + 'parent-student/add-existing-student'
		});
	}

	manageStudentApi.submitCode = function(id, code) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {client_id : id, invitation_code : code}
			, url 	: studentApiUrl + 'parent-student/confirm-student'
		});
	}

	manageStudentApi.addStudent = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: studentApiUrl + 'client/manage/student'
		});
	}
	return manageStudentApi;
}