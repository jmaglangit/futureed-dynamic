angular.module('futureed.services')
	.factory('ClientPasswordService', ClientPasswordService);

ClientPasswordService.$http = ['$http'];

function ClientPasswordService($http){
	var api = {};
	var apiUrl = '/api/v1/';

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

	api.resetClientPassword = function(id, reset_code, password) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {reset_code : reset_code, password : password}
			, url	: apiUrl + 'client/reset-password/' + id
		});
	}

	api.setClientPassword = function(id, password) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {password : password}
			, url	: apiUrl + 'client/new-password/' + id
		});
	}
	return api;
}