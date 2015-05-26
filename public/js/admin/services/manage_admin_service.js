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

	function getAdminList(){
		return $http({
			method 	: Constants.METHOD_GET
			, url 	: adminApiUrl + 'admin'
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
	return manageAdminApi;
}