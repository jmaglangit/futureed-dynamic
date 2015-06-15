angular.module('futureed.controllers')
	.controller('ManageParentStudentController', ManageParentStudentController);

ManageParentStudentController.$inject = ['$scope', 'ManageParentStudentService', 'apiService'];

function ManageParentStudentController($scope, ManageParentStudentService, apiService) {
	var self = this;

	self.existActive = existActive;
	self.setActive = setActive;

	function existActive(req) {
		
		switch(req) {
			case 'new':
				self.exist = Constants.TRUE;
				break
			case 'old':
			default:
				self.exist = Constants.FALSE;
				break
		}
	}

	function setActive(req) {

		switch(req) {
			case 'edit':
				self.edit_form = Constants.TRUE;
				self.disabled = Constants.TRUE;
				break
		}
	}
}