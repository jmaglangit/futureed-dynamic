angular.module('futureed.services')
	.factory('StudentReportsService', StudentReportsService);

StudentReportsService.$http = ['$http'];

function StudentReportsService($http) {
	var api = {};
	var apiUrl = '/api/';

	api.reportCard = function(id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'dashboard/student/' + id
		});
	}

	api.summaryProgress = function(student_id, subject_id) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'dashboard/student-progress/' + student_id + '/' + subject_id
		});
	}
	
	api.listClass = function(student_id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'v1/class-student/student-class-list?student_id=' + student_id
		});
	}

	//GET api/dashboard/student-progress/current-learning/{student_id}/{subject_id}
	api.currentLearning = function (student_id, subject_id) {
		return $http({
			method	: Constants.METHOD_GET
			, url	: apiUrl + 'dashboard/student-progress/current-learning/' + student_id + '/' + subject_id
		});
	}

	//GET /api/dashboard/student-progress/curriculum/{student_id}/{subject_id}
	api.subjectArea = function (student_id, subject_id) {
		return $http({
			method	:	Constants.METHOD_GET
			,	url	:	apiUrl + 'dashboard/student-progress/curriculum/' + student_id + '/' + subject_id
		});
	}

	return api;	
}