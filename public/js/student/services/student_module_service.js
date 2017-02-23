angular.module('futureed.services')
	.factory('StudentModuleService', StudentModuleService);

StudentModuleService.$http = ['$http'];

function StudentModuleService($http){
	var service = {};
	var serviceUrl = '/api/v1/';

	service.getTrialModule = function() {
		return $http({
			method	:	Constants.METHOD_GET,
			url		:	serviceUrl + "trial"
		});
	}

	service.getSnapModule = function(filename) {
		return $http({
			method	:	Constants.METHOD_GET,
			url		:	serviceUrl + "snap/" + filename
		});
	}

	service.getSnapQuestionDetails = function(data) {
		return $http({
			method  :	Constants.METHOD_PUT,
			url     :	serviceUrl + "snap/" + data.q_id + "?class=" + data.c_id
		});
	}

	service.answerSnapExercise = function(data) {
		return $http({
			method  : Constants.METHOD_POST,
			data    : data,
			url     : serviceUrl + "snap"
		});
	}

	service.validateAnswer = function(data){
		return $http({
			method	:	Constants.METHOD_POST,
			data	:	data,
			url		:	serviceUrl + "trial"
		});
	}

	service.getModuleDetail = function(id) {
		return $http({
			method  : Constants.METHOD_GET,
			url  	: serviceUrl + "module/" + id
		});
	}

	service.getTeachingContents = function(search, table) {
		return $http({
			method  : Constants.METHOD_GET,
			url     : serviceUrl + "teaching-module/student?module_id=" + search.module_id
				// + '&limit=' + table.size
				// + '&offset=' + table.offset
		});
	}

	service.updateModuleStudent = function(data) {
		return $http({
			method  : Constants.METHOD_PUT,
			data    : data,
			url  	: serviceUrl + 'module/student/' + data.module_id
		});
	}

	service.getModuleStudent = function(module_id) {
		return $http({
			method  : Constants.METHOD_GET,
			url     : serviceUrl + 'module/student/' + module_id
		});
	}

	service.createModuleStudent = function(data) {
		return $http({
			method  : Constants.METHOD_POST,
			data    : data,
			url     : serviceUrl + 'module/student'
		});
	}

	service.listQuestions = function(search, table) {
		return $http({
			method  : Constants.METHOD_GET,
			url     : serviceUrl + 'question?module_id=' + search.module_id
		});
	}

	service.answerQuestion = function(data) {
		return $http({
			method  : Constants.METHOD_POST,
			data    : data,
			url     : serviceUrl + 'student-module-answer'
		});
	}

	service.listAvatarQuotes = function(avatar_id) {
		return $http({
			method  : Constants.METHOD_GET,
			url     : serviceUrl + 'quote?avatar_id=' + avatar_id
		});
	}

	service.getAvatarPose = function(avatar_id) {
		return $http({
			method  : Constants.METHOD_GET,
			url     : serviceUrl + 'avatar-pose?avatar_id=' + avatar_id
		});
	}

	service.getPointsEarned = function(data) {
		return $http({
			method  : Constants.METHOD_GET,
			url     : serviceUrl + 'module-group?age_group=' + data.age_group
				+ '&module_id=' + data.module_id
		});
	}

	service.saveStudentPoints = function(data) {
		return $http({
			method  : Constants.METHOD_POST,
			data    : data,
			url     : serviceUrl + 'student-point'
		});
	}

	service.getWiki = function(avatar_id) {
		return $http({
			method  : Constants.METHOD_GET,
			url     : serviceUrl + 'avatar-wiki?avatar_id=' + avatar_id
		});
	}

	service.listClass = function(student_id) {
		return $http({
			method 	: Constants.METHOD_GET,
			url     : serviceUrl + 'class-student/student-class-list?student_id=' + student_id
		});
	}

	service.getGraph = function(question_id) {
		return $http({
			method 	: Constants.METHOD_GET,
			url     : serviceUrl + 'student/question/graph/' + question_id
		});
	}

	service.getAnswerExplanation = function(data){
		return $http({
			method	:	Constants.METHOD_GET,
			url	    :	serviceUrl + 'answer-explanation?'
				+	'module_id=' +	data.module_id
				+	'&question_id='	+	data.question_id
				+	'&seq_no='	+	data.seq_no
		});
	}

	return service;
}