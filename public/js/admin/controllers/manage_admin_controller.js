angular.module('futureed.controllers')
	.controller('ManageAdminController', ManageAdminController);

ManageAdminController.$inject = ['$scope', 'manageAdminService'];

function ManageAdminController($scope, manageAdminService) {
	
	var self = this;

	this.getAdminList = getAdminList;
	this.addAdmin = addAdmin;

	function getAdminList(){

		manageAdminService.getAdminList().success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data){
					self.data = response.data.records;
				}
			}
		}).error(function(response) {
			this.internalError();
		});
	}

	function addAdmin(){
		self.add_admin = Constants.TRUE;
	}	
}