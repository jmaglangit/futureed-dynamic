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

	//student question analysis
	//api/report/student-progress/question-answer-report
	//student_id:1
	//subject_id:1
	//grade_id:1
	//module_id:1
	api.questionAnalysis = function(data){
		return $http({
			method	:	Constants.METHOD_GET
			, url	:	apiUrl + 'report/student-progress/question-answer-report'
						+ '?student_id=' + data.student_id
						+ '&subject_id=' + data.subject_id
						+ '&grade_id='   + data.grade_id
						+ '&module_id='  + data.module_id
		});
	}

	api.getIAssessDownloadLinkReport = function (student_id) {
		return $http({
			method	: Constants.METHOD_GET
			, url	: apiUrl + 'v1/assess/download-report/' + student_id
		});
	}

	//api/report/student-chart/platform-hours/{student_id}
	api.getStudentChartMonthHours = function(student_id){
		return $http({
			method	:	Constants.METHOD_GET,
			url		:	apiUrl + 'report/student-chart/platform-hours/' + student_id
		});
	}

	//api/report/student-chart/platform-week-hours/{student_id}
	api.getStudentChartWeekHours = function(student_id){
		return $http({
			method	:	Constants.METHOD_GET,
			url		: apiUrl + 'report/student-chart/platform-week-hours/' + student_id
		});
	}

	//api/report/student-chart/platform-subject-area-completed/{student_id}
	api.getStudentChartSubjectArea = function(data){
		return $http({
			method	:	Constants.METHOD_GET,
			url		:	apiUrl + 'report/student-chart/platform-subject-area-completed/' + data.student_id
						+ '?subject_id=' + ((data.subject_id) ? data.subject_id : '')
						+ '&grade_id=' + ((data.grade_id) ? data.grade_id : '')
		});
	}

	//api/report/student-chart/platform-subject-area-heatmap/{student_id}/{subject_id}/{grade_id}
	api.getStudentChartSubjectAreaHeatMap = function(data){
		return $http({
			method	:	Constants.METHOD_GET,
			url		:	apiUrl + 'report/student-chart/platform-subject-area-heatmap/' + data.student_id
						+ '?subject_id=' + ((data.subject_id) ? data.subject_id : '')
						+ '&grade_id=' + ((data.grade_id) ? data.grade_id : '')
		});
	}

	return api;	
}