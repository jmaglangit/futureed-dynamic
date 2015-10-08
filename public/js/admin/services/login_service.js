angular.module('futureed.services')
	.factory('AdminLoginApiService', AdminLoginApiService);

function AdminLoginApiService($http) {
	var api = {};
	var apiUrl = '/api/v1/';

	api.adminDoLogin = function(username, password){
		return $http({
			method	: Constants.METHOD_POST
			, data 	: {username : username, password : password}
			, url 	: apiUrl + 'admin/login'
		});
	}

	api.resetPassword = function(id, reset_code, new_password){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {reset_code : reset_code, password : new_password}
			, url 	: apiUrl + 'admin/forgot-password/' + id
		});
	}

	api.forgotPassword = function(username, user_type, callback_uri) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: {username: username, user_type : user_type, callback_uri : callback_uri}
			, url	: apiUrl + 'user/password/forgot'
		});
	}

	api.resendResetCode = function(email, user_type, callback_uri) {
		return $http({
			method 	: Constants.METHOD_POST
			, data	: {email: email, user_type : user_type, callback_uri : callback_uri}
			, url	: apiUrl + 'user/reset/code'
		});
	}

	api.validateCode = function(reset_code, email, user_type) {
		return $http({
			method	: Constants.METHOD_POST
			, data 	: {email : email, user_type : user_type, reset_code : reset_code}
			, url	: apiUrl + 'user/password/code'
		});
	}

	return api;
}