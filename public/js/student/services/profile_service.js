angular.module('futureed.services')
	.factory('ProfileService', ProfileService);

ProfileService.$inject = ['$http'];

function ProfileService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.getCountryDetails = function(id) {
		return $http({
			  method 	: Constants.METHOD_GET
			, url	: apiUrl + 'countries/' + id
		});
	}

	api.getBadges = function(id) {
		return $http({
			  method 	: Constants.METHOD_GET
			, url	: apiUrl + 'badge/student?student_id=' + id
		});
	}

	api.getPoints = function(id) {
		return $http({
			  method 	: Constants.METHOD_GET
			, url	: apiUrl + 'student-point?student_id=' + id
		});
	}

	api.getPointLevel = function(points_required) {
		return $http({
			  method 	: Constants.METHOD_GET
			, url	: apiUrl + 'point-level/' + points_required
		});
	}

	api.getLoginPassword = function(data) {
		return $http({
			method	: Constants.METHOD_POST
			, data	: data
			, url	: apiUrl + 'student/login/image'
		});
	}

	api.validateCurrentPassword = function(data) {
		return $http({
			method	: Constants.METHOD_POST
			, data 	: data
			, url 	: apiUrl + 'student/password/confirm/' + data.id
		});
	}

	api.getImagePassword = function() {
		return $http({
			method 	: Constants.METHOD_GET
			, url	: apiUrl + 'student/password/image'
		});
	}

	api.changePassword = function(data) {
		return $http({
			method	: Constants.METHOD_POST
			, data 	: data
			, url 	: apiUrl + 'student/password/' + data.id
		});
	}

	api.getStudentBackgroundImage = function(id) {
		return $http({
			method	: Constants.METHOD_GET
			, url	: apiUrl + 'student/background-image/' + id
		});
	}

	api.updateStudentBackgroundImage = function(data) {
		return $http({
			method	:	Constants.METHOD_PUT
			, data	:	{'background_image_id' : data.background_image_id }
			, url	:	apiUrl + 'student/background-image/' + data.user_id
		});
	}

	api.getBackgroundImage = function() {
		return $http({
			method	: Constants.METHOD_GET
			, url	: apiUrl + 'background-image'
		});
	}

	return api;
}