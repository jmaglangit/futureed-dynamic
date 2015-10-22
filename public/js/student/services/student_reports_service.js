angular.module('futureed.services')
	.factory('StudentReportsService', StudentReportsService);

StudentReportsService.$http = ['$http'];

function StudentReportsService($http) {
	var api = {};
	var apiUrl = '/api/';

	api.reportCard = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'report/student/' + id
		});
	}

	api.summaryProgress = function(student_id, subject_id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'report/student-progress/' + student_id + '/' + subject_id
		});
	}
	
	api.listClass = function(student_id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'v1/class-student/student-class-list?student_id=' + student_id
		});
	}
	

	return api;	
}