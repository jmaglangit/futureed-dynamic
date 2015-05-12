angular.module('futureed.services')
	.factory('clientProfileApiService', clientProfileApiService);

function clientProfileApiService($http) {
	var clientProfileApi = {};
	var clientProfileApiUrl = '/api/v1/';

	clientProfileApi.getClientDetails = getClientDetails;
	clientProfileApi.saveClientProfile = saveClientProfile;
	clientProfileApi.changeClientPassword = changeClientPassword;

	function getClientDetails(id) {
		return $http({
			method 	: 'GET'
			, url	: clientProfileApiUrl + 'client/' + id
		});
	}

	function saveClientProfile(data) {
		return $http({
			method	: 'PUT'
			, data	: data
			, url 	: clientProfileApiUrl + 'client/' + data.id
		});
	}

	function changeClientPassword(id, object) {
		return $http({
			method	: 'POST'
			, data 	: {password : object.password, new_password : object.new_password}
			, url 	: clientProfileApiUrl + 'client/change-password/' + id
		});
	}

	return clientProfileApi;
}