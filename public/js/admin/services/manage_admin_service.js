angular.module('futureed.services')
	.factory('manageAdminService', manageAdminService);

function manageAdminService($http) {
	var adminApiUrl = '/api/v1/';
	var manageAdminApi = {};

	manageAdminApi.getAdminList = function(user, email, role){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'admin?username=' + user
				+ '&email=' + email + '&role=' + role
		});
	}

	manageAdminApi.checkUserAvailable = function(username, user_type){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {username : username, user_type : user_type}
			, url 	: adminApiUrl + 'user/username'
		});
	}

	manageAdminApi.saveAdmin = function(data){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: adminApiUrl + 'admin'
		});
	}

	manageAdminApi.viewAdmin = function(id){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'admin/' + id
		})
	}

	manageAdminApi.editAdmin = function(data){
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data 
			, url 	: adminApiUrl + 'admin/' + data.id
		})
	}

	manageAdminApi.resetPass = function(password, id){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {new_password : password}
			, url 	: adminApiUrl + 'admin/change-password/' + id

		});
	}

	manageAdminApi.changeAdminEmail = function(id, new_email, callback_uri) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {new_email : new_email, callback_uri : callback_uri}
			, url 	: adminApiUrl + 'admin/change-email/' + id

		});
	}
	
	manageAdminApi.checkAdminEmail = function(id, email) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {email : email}
			, url 	: adminApiUrl + 'admin/check-email/' + id

		});
	}
	
	return manageAdminApi;
}