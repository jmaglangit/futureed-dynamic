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

	//GET api/report/student-progress/current-learning/{student_id}/{subject_id}
	api.currentLearning = function (student_id, subject_id) {
		return $http({
			method	: Constants.METHOD_GET
			, url	: apiUrl + 'report/student-progress/current-learning/' + student_id + '/' + subject_id
		});
	}

	//GET /api/report/student-progress/curriculum/{student_id}/{subject_id}
	api.subjectArea = function (student_id, subject_id) {
		return $http({
			method	:	Constants.METHOD_GET
			,	url	:	apiUrl + 'report/student-progress/curriculum/' + student_id + '/' + subject_id
		});
	}

	api.subjectAreaHeatmap = function (student_id, subject_id) {
		return $http({
			method	:	Constants.METHOD_GET
			,	url	:	apiUrl + 'report/student-progress/curriculum/heat-map/' + student_id + '/' + subject_id
		});
	}

	//api/v1/assess/download-report/{student_id}
	api.getIAssessDownloadLinkReport = function (student_id) {
		return $http({
			method	: Constants.METHOD_GET
			, url	: apiUrl + 'v1/assess/download-report/' + student_id
		});
	}

	return api;	
}