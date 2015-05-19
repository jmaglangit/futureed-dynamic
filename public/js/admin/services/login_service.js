angular.module('futureed.services')
	.factory('adminLoginApiService', adminLoginApiService);

function adminLoginApiService($http) {
	var adminLoginApi = {};
	var adminLoginApiUrl = '/api/v1/';

	adminLoginApi.adminDoLogin = adminDoLogin;

	function adminDoLogin(username, password){
		return $http({
			method	: Constants.METHOD_POST
			, data 	: {username : username, password : password}
			, url 	: adminLoginApiUrl + 'admin/login'
		});
	}

	return adminLoginApi;
}