angular.module('futureed.services')
	.factory('clientProfileApiService', clientProfileApiService);

function clientProfileApiService($http) {
	var clientProfileApi = {};
	var clientProfileApiUrl = '/api/v1/';

	clientProfileApi.getClientDetails = getClientDetails;
	clientProfileApi.saveClientProfile = saveClientProfile;

	clientProfileApi.changeClientEmail = changeClientEmail;
	clientProfileApi.confirmClientEmail = confirmClientEmail;
	clientProfileApi.resendClientEmailCode = resendClientEmailCode;

	clientProfileApi.changeClientPassword = changeClientPassword;

	clientProfileApi.updateUserSession = updateUserSession;
	

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

	function changeClientEmail(id, object, callback_uri) {
		return $http({
			method 	: 'POST'
			, data 	: {new_email: object.new_email, password : object.password, callback_uri : callback_uri}
			, url 	: clientProfileApiUrl + 'client/change-email/' + id
		});
	}

	function confirmClientEmail(id, user_type, confirmation_code, new_email) {
		return $http({
			method	: 'POST'
			, data	: {new_email : new_email, confirmation_code : confirmation_code, user_type : user_type}
			, url 	: clientProfileApiUrl + 'client/update-email/' + id
		});
	}

	function resendClientEmailCode(id, user_type, callback_uri) {
		return $http({
			method	: 'POST'
			, data 	: {user_type : user_type, callback_uri : callback_uri}
			, url 	: clientProfileApiUrl + 'client/resend-email/' + id
		});
	}

	function changeClientPassword(id, object) {
		return $http({
			method	: 'POST'
			, data 	: {password : object.password, new_password : object.new_password}
			, url 	: clientProfileApiUrl + 'client/change-password/' + id
		});
	}

	function updateUserSession(user) {
		return $http({
			method	: 'POST',
			data 	: user,
			url		: '/client/update-user-session'
		});
	}

	return clientProfileApi;
}