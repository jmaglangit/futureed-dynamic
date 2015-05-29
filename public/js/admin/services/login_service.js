angular.module('futureed.services')
	.factory('adminLoginApiService', adminLoginApiService);

function adminLoginApiService($http) {
	var adminLoginApi = {};
	var adminLoginApiUrl = '/api/v1/admin';

	adminLoginApi.adminDoLogin = function(username, password){
		return $http({
			method	: Constants.METHOD_POST
			, data 	: {username : username, password : password}
			, url 	: adminLoginApiUrl + '/login'
		});
	}

	adminLoginApi.adminResetPass = function(id, reset_code, new_password){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {reset_code : reset_code, password : new_password}
			, url 	: adminLoginApiUrl + '/forgot-password/' + id
		});
	}

	return adminLoginApi;
}