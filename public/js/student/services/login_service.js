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

	api.getLoginPassword = function(data) {
		return $http({
			method	: Constants.METHOD_POST
			, data	: data
			, url	: apiUrl + 'student/login/image'
		});
	}

	api.validatePassword = function(data) {
		return $http({
			method	: Constants.METHOD_POST
			, data	: data
			, url	: apiUrl + 'student/login/password'
		});
	}

	api.validateRegistration = function(data) {
		return $http({
			method	: Constants.METHOD_POST
			, data	: data
			, url	: apiUrl + 'student/register'
		});
	}

	api.editRegistration = function(data) {
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data 	
			, url	: apiUrl + 'client/manage/update-student/' + data.id
		});
	}

	api.confirmCode = function(email, email_code, user_type) {
		return $http({
			method	: Constants.METHOD_POST
			, data 	: {email : email, email_code : email_code, user_type : user_type}
			, url	: apiUrl + 'user/email/code'
		});
	}

	api.resendConfirmation = function(email, user_type, callback_uri) {
		return $http({
			method	: Constants.METHOD_POST
			, data 	: {email : email, user_type : user_type, callback_uri : callback_uri}
			, url	: apiUrl + 'user/confirmation/code'
		});
	}

	api.setPassword = function (id, password_image_id) {
		return $http({
			method	: Constants.METHOD_POST
			, data	: {id : id, password_image_id : password_image_id}
			, url	: apiUrl + 'student/password/new'
		});
	}

	api.getStudentDetails = function(id, token) {
		return $http({
			method : Constants.METHOD_GET
			, url  : apiUrl + 'client/manage/view-student/' + id
				+ '?registration_token=' + token
		})
	}

	return api;
}