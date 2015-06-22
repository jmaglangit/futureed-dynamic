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

	return manageStudentApi;
}