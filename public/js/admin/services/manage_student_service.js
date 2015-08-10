angular.module('futureed.services')
	.factory('manageStudentService', manageStudentService);

function manageStudentService($http) {
	var adminApiUrl = '/api/v1/';
	var manageStudentApi = {};

	manageStudentApi.getStudentlist = function(search, table) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'admin/manage/student?name=' + search.name
				+ '&email=' + search.email
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	manageStudentApi.save = function(data) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: adminApiUrl + 'admin/manage/student'
		})
	}

	/**
	* Search School
	*
	* @Param
	*		school_name		- [Optiona] the school name
	*/
	manageStudentApi.searchSchool = function(school_name) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'school/search?school_name=' + school_name
		});
	}

	manageStudentApi.viewStudent = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'admin/manage/student/' + id
		});
	}

	manageStudentApi.saveEdit = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data
			, url 	: adminApiUrl + 'admin/manage/student/' + data.id
		});
	}

	manageStudentApi.deleteStudent = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: adminApiUrl + 'admin/manage/student/' + id
		});
	}

	manageStudentApi.moduleList = function(id) {
		return $http({
			method 	: Constants.METHOD_GET	
			, url 	: adminApiUrl + 'module/student?student_id=' + id
		});
	}

	manageStudentApi.resetModule = function(id) {
		return $http({
			method 	: Constants.METHOD_PUT	
			, url 	: adminApiUrl + 'reset/student-module/' + id
		});
	}

	manageStudentApi.getPoints = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'student-point?student_id=' + id
		});
	}

	manageStudentApi.getBadges = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'badge/student?student_id=' + id
		});
	}

	manageStudentApi.getPointDetail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'student-point/' + id
		});
	}

	manageStudentApi.getEvents = function(event) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'event?name=' + event
		});
	}

	manageStudentApi.savePoint = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data	
			, url 	: adminApiUrl + 'student-point/' + data.id
		});
	}

	manageStudentApi.getBadgeDetail = function(id) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'badge/student/' + id
		});
	}

	manageStudentApi.getAllBadges = function(name) {
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'badge/admin?name=' + name
		});
	}

	manageStudentApi.saveBadge = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: {badge_id : data.badge_id}	
			, url 	: adminApiUrl + 'badge/student/' + data.id
		});
	}

	manageStudentApi.deleteBadge = function(id) {
		return $http({
			method 	: Constants.METHOD_DELETE	
			, url 	: adminApiUrl + 'badge/student/' + id
		});
	}
	return manageStudentApi
}