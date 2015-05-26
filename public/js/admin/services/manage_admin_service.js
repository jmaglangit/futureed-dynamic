angular.module('futureed.services')
	.factory('manageAdminService', manageAdminService);

function manageAdminService($http) {
	var adminApiUrl = '/api/v1/';
	var manageAdminApi = {};

	manageAdminApi.getAdminList = getAdminList;
	manageAdminApi.checkUserAvailable = checkUserAvailable;
	manageAdminApi.saveAdmin = saveAdmin;
	manageAdminApi.viewAdmin = viewAdmin;
	manageAdminApi.editAdmin = editAdmin;
	manageAdminApi.resetPass = resetPass;
	manageAdminApi.changeAdminEmail = changeAdminEmail;

	function getAdminList(user, email, role){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'admin?username=' + user
				+ '&email=' + email + '&role=' + role
		});
	}

	function checkUserAvailable(username, user_type){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {username : username, user_type : user_type}
			, url 	: adminApiUrl + 'user/username'
		});
	}

	function saveAdmin(data){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: data
			, url 	: adminApiUrl + 'admin'
		});
	}

	function viewAdmin(id){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'admin/' + id
		})
	}

	function editAdmin(data){
		return $http({
			method 	: Constants.METHOD_PUT
			, data 	: data 
			, url 	: adminApiUrl + 'admin/' + data.id
		})
	}

	function resetPass(password, id){
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {new_password : password}
			, url 	: adminApiUrl + 'admin/change-password/' + id

		});
	}

	function changeAdminEmail(id, new_email, callback_uri) {
		return $http({
			method 	: Constants.METHOD_POST
			, data 	: {new_email : new_email, callback_uri : callback_uri}
			, url 	: adminApiUrl + 'admin/change-email/' + id

		});
	}
	return manageAdminApi;
}