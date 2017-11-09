angular.module('futureed.services')
	.factory('ManageAdminService', ManageAdminService);

function ManageAdminService($http) {
	var serviceUrl = '/api/v1/';
	var service = {};

	service.getAdminList = function(search, table){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'admin?username=' + search.user
				+ '&email=' + search.email 
				+ '&role=' + search.role
				+ '&limit=' + table.size
				+ '&offset=' + table.offset
		});
	}

	service.checkUserAvailable = function(username, user_type){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {username : username, user_type : user_type}
			, url 	: serviceUrl + 'user/username'
		});
	}

	service.saveAdmin = function(data){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: serviceUrl + 'admin'
		});
	}

	service.viewAdmin = function(id){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: serviceUrl + 'admin/' + id
		})
	}

	service.editAdmin = function(data){
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data 
			, url 	: serviceUrl + 'admin/' + data.id
		})
	}

	service.resetPass = function(password, id){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {new_password : password}
			, url 	: serviceUrl + 'admin/change-password/' + id

		});
	}

	service.changeAdminEmail = function(id, new_email, callback_uri) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {new_email : new_email, callback_uri : callback_uri}
			, url 	: serviceUrl + 'admin/change-email/' + id

		});
	}
	
	service.checkAdminEmail = function(id, email) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {email : email}
			, url 	: serviceUrl + 'admin/check-email/' + id

		});
	}

	service.deleteModeAdmin = function(id){
		return $http({
			method 	: Constants.METHOD_DELETE
			, url 	: serviceUrl + 'admin/' + id
		})
	}
	
	return service;
}