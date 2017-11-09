angular.module('futureed.services')
	.factory('ClientLoginApiService', ClientLoginApiService);

function ClientLoginApiService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.clientLogin = function(username, password, role) {
		return $http({
			method	: Constants.METHOD_POST
			, data 	: {username : username, password : password, role : role}
			, url	: apiUrl + 'client/login'
		});
	}

	api.registerClient = function(data) {
		return $http({
			method	: Constants.METHOD_POST
			, data	: data
			, url 	: apiUrl + 'client/register'
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

	api.setClientPassword = function(id, password) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {password : password}
			, url	: apiUrl + 'client/new-password/' + id
		});
	}

	api.getTeacherDetails = function(id, registration_token) {
		return $http({
			method 	: Constants.METHOD_GET
			, url	: apiUrl + 'client/teacher-information/' + id
				+ '?registration_token=' + registration_token
		});
	}

	api.updateClientRegistration = function(data) {
		return $http({
			method : Constants.METHOD_PUT
			, data : data
			, url  : apiUrl + 'client/teacher-information/' + data.id 
		});
	}

	return api;
}