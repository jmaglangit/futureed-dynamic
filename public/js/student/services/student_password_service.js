angular.module('futureed.services')
	.factory('StudentPasswordService', StudentPasswordService);

StudentPasswordService.$http = ['$http'];

function StudentPasswordService($http){
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

	api.resetPassword = function (id, code, image_id) {
			return $http({
				method	: Constants.METHOD_POST
				, data	: {id : id, reset_code : code, password_image_id : image_id}
				, url	: apiUrl + 'student/password/reset'
			});
		}

	api.setPassword = function (id, password_image_id) {
		return $http({
			method	: Constants.METHOD_POST
			, data	: {id : id, password_image_id : password_image_id}
			, url	: apiUrl + 'student/password/new'
		});
	}

	return api;
}