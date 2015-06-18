angular.module('futureed.services')
	.factory('clientLoginApiService', clientLoginApiService);

function clientLoginApiService($http) {
	var clientLoginApi = {};
	var clientLoginApiUrl = '/api/v1/client';

	clientLoginApi.clientLogin = function(username, password, role) {
		return $http({
			method	: Constants.METHOD_POST
			, data 	: {username : username, password : password, role : role}
			, url	: clientLoginApiUrl + '/login'
		});
	}

	clientLoginApi.registerClient = function(data) {
		return $http({
			method	: Constants.METHOD_POST
			, data	: data
			, url 	: clientLoginApiUrl + '/register'
		});
	}

	clientLoginApi.resetClientPassword = function(id, reset_code, password) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {reset_code : reset_code, password : password}
			, url	: clientLoginApiUrl + '/reset-password/' + id
		});
	}

	clientLoginApi.setClientPassword = function(id, password) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {password : password}
			, url	: clientLoginApiUrl + '/new-password/' + id
		});
	}

	clientLoginApi.getTeacherDetails = function(id, registration_token) {
		return $http({
			method 	: Constants.METHOD_GET
			, url	: clientLoginApiUrl + '/teacher-information/' + id
				+ '?registration_token=' + registration_token
		});
	}

	clientLoginApi.updateClientRegistration = function(data) {
		return $http({
			method : Constants.METHOD_PUT
			, data : data
			, url  : clientLoginApiUrl + '/teacher-information/' + data.id 
		});
	}

	return clientLoginApi;
}