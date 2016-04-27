angular.module('futureed.services')
	.factory('ManageParentReportsService', ManageParentReportsService);

ManageParentReportsService.$inject = ['$http'];

function ManageParentReportsService($http) {
	var api = {};
	var apiUrl = '/api/';

	api.listClass = function(student_id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'v1/class-student/student-class-list?student_id=' + student_id
		});
	}

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
			method: Constants.METHOD_GET
			, url: apiUrl + 'report/student-progress/curriculum/heat-map/' + student_id + '/' + subject_id
		});
	}

	// /api/v1/client/manage/student?client_id={id of client}&name=&email=&limit=&offset=0
	api.listStudents = function(client_id){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: apiUrl + 'v1/client/manage/student?client_id='+client_id
			+ '&offset=0'
		})
	}
	
	return api;
}