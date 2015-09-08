angular.module('futureed.services')
	.factory('StudentClassService', StudentClassService);

function StudentClassService($http){
	var service = {};
	var serviceUrl = '/api/v1/';

	service.submitTips = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: serviceUrl + 'tip/student'
		});
	}
	service.submitHelp = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: serviceUrl + 'help-request'
		});
	}

	service.listTips = function(class_id, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'tip/student?class_id=' + class_id
				+ "&limit=" + table.size
				+ "&offset=" + table.offset
		});
	}

	service.listHelpRequests = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'help-request?class_id=' + search.class_id
				+ "&order_by_date=" + search.order_by_date
				+ "&request_status=" + search.request_status
				+ "&limit=" + table.size
				+ "&offset=" + table.offset
		});
	}

	service.listClass = function(student_id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'class-student/student-class-list?student_id=' + student_id
		});
	}

	service.listModules = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'class-student/student-current-class?student_id=' + search.student_id
				+ '&class_id=' + search.class_id
				+ '&grade_id=' + search.grade_id
				+ '&module_status=' + search.module_status
				+ '&module_name=' + search.module_name
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	service.getSubjects = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'subject'
		});
	}

	return service;
}