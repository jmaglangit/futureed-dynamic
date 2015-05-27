angular.module('futureed.services')
	.factory('adminLoginApiService', adminLoginApiService);

function adminLoginApiService($http) {
	var adminLoginApi = {};
	var adminLoginApiUrl = '/api/v1/';

	adminLoginApi.adminDoLogin = adminDoLogin;
	adminLoginApi.adminResetPass = adminResetPass;

	function adminDoLogin(username, password){
		return $http({
			method	: Constants.METHOD_POST
			, data 	: {username : username, password : password}
			, url 	: adminLoginApiUrl + 'admin/login'
		});
	}

	function adminResetPass(id, reset_code, new_password){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {reset_code : reset_code, new_password : new_password}
			, url 	: adminLoginApiUrl + 'admin/change-password/' + id
		});
	}

	return adminLoginApi;
}