angular.module('futureed.services')
	.factory('ManageTeacherStudentService', ManageTeacherStudentService);

ManageTeacherStudentService.$inject = ['$http'];

function ManageTeacherStudentService($http){
	var manageTeacherStudentApi = {};
	var teacherStudentApiUrl = '/api/v1/';


	
	
	return manageTeacherStudentApi;
}