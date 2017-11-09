angular.module('futureed.services')
	.factory('clientProfileApiService', clientProfileApiService);

function clientProfileApiService($http) {
	var clientProfileApi = {};
	var clientProfileApiUrl = '/api/v1/client';

	clientProfileApi.getClientDetails = function(id) {
		return $http({
			method 	: 'GET'
			, url	: clientProfileApiUrl + '/' + id
		});
	}

	clientProfileApi.saveClientProfile = function(data) {
		return $http({
			method	: 'PUT'
			, data	: data
			, url 	: clientProfileApiUrl + '/' + data.id
		});
	}

	clientProfileApi.changeClientEmail = function(id, object, callback_uri) {
		return $http({
			method 	: 'POST'
			, data 	: {new_email: object.new_email, password : object.password, callback_uri : callback_uri}
			, url 	: clientProfileApiUrl + '/change-email/' + id
		});
	}

	clientProfileApi.confirmClientEmail = function(id, user_type, confirmation_code, new_email) {
		return $http({
			method	: 'POST'
			, data	: {new_email : new_email, confirmation_code : confirmation_code, user_type : user_type}
			, url 	: clientProfileApiUrl + '/update-email/' + id
		});
	}

	clientProfileApi.resendClientEmailCode = function(id, user_type, callback_uri) {
		return $http({
			method	: 'POST'
			, data 	: {user_type : user_type, callback_uri : callback_uri}
			, url 	: clientProfileApiUrl + '/resend-email/' + id
		});
	}

	clientProfileApi.changeClientPassword = function(id, object) {
		return $http({
			method	: 'POST'
			, data 	: {password : object.password, new_password : object.new_password}
			, url 	: clientProfileApiUrl + '/change-password/' + id
		});
	}

	clientProfileApi.updateUserSession = function(user) {
		return $http({
			method	: 'POST',
			data 	: user,
			url		: '/client/update-user-session'
		});
	}

	return clientProfileApi;
}