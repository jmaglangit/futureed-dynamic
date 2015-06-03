angular.module('futureed.services')
	.factory('manageTeacherService', manageTeacherService);

function manageTeacherService($http){

	var teacherApiUrl = '/api/v1/';
	var manageTeacherApi = {};

	manageTeacherApi.getTeacherList = getTeacherList;
	manageTeacherApi.viewTeacher = viewTeacher;
	manageTeacherApi.saveTeacher = saveTeacher;

	function getTeacherList(name, email){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: teacherApiUrl + 'client/teacher?name=' + name
				+ '&email=' + email
		});
	}

	function viewTeacher(id){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: teacherApiUrl + 'client/teacher/'+ id
		});
	}

	function saveTeacher(data){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data 
			, url 	: teacherApiUrl + 'client/teacher'
		});
	}	


	return manageTeacherApi;
}