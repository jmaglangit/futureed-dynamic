angular.module('futureed.services')
	.factory('StudentLoginService', StudentLoginService);

StudentLoginService.$inject = ['$http'];

function StudentLoginService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.registerFB = function(data) {
		return $http({
			  method 	: Constants.METHOD_POST
			, data 		: data 
			, url		: apiUrl + 'registration/facebook'
		});
	}

	api.registerGoogle = function(data) {
		return $http({
			  method 	: Constants.METHOD_POST
			, data 		: data
			, url		: apiUrl + 'registration/google'
		});
	}

	api.loginFacebook = function(data) {
		return $http({
			  method 	: Constants.METHOD_POST
			, data 		: data
			, url		: apiUrl + 'login/facebook'
		});
	}

	api.loginGoogle = function(data) {
		return $http({
			  method 	: Constants.METHOD_POST
			, data 		: data
			, url		: apiUrl + 'login/google'
		});
	}

	api.validateUser = function(username) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: { username : username} 
			, url	: apiUrl + 'student/login/username'
		});
	}

	api.validatePassword = function(id, image_id) {
		return $http({
			method	: Constants.METHOD_POST
			, data	: {id : id, image_id : image_id}
			, url	: apiUrl + 'student/login/password'
		});
	}

	return api;
}