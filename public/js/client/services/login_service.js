angular.module('futureed.services')
	.factory('clientLoginApiService', clientLoginApiService);

function clientLoginApiService($http) {
	var clientLoginApi = {};
	var clientLoginApiUrl = '/api/v1/';

	clientLoginApi.clientLogin = clientLogin;
	clientLoginApi.registerClient = registerClient;
	clientLoginApi.resetClientPassword = resetClientPassword;

	function clientLogin(username, password, role) {
		return $http({
			method	: Constants.METHOD_POST
			, data 	: {username : username, password : password, role : role}
			, url	: clientLoginApiUrl + 'client/login'
		});
	}

	function registerClient(data) {
		return $http({
			method	: Constants.METHOD_POST
			, data	: data
			, url 	: clientLoginApiUrl + 'client/register'
		});
	}

	function resetClientPassword(id, reset_code, password) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {reset_code : reset_code, password : password}
			, url	: futureedAPIUrl + 'client/reset-password/' + id
		});
	}

	return clientLoginApi;
}