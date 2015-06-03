angular.module('futureed.controllers')
	.controller('ManageInvoiceController', ManageInvoiceController);

ManageInvoiceController.$inject = ['$scope', 'manageInvoiceService', 'apiService'];

function ManageInvoiceController($scope, manageInvoiceService, apiService) {

	var self = this;

	self.setActive = setActive;

	function setActive(active){
		switch(active){
			case 'cancel':
				self.edit_form = Constants.FALSE;
				self.list_form = Constants.FALSE;
				self.edit = Constants.FALSE;
				break

			case 'edit':
				self.edit_form = Constants.TRUE;
				self.list_form = Constants.FALSE;
				self.edit = Constants.TRUE;
				break

			case 'list':
			default:
				self.list_form = Constants.TRUE;
				break

		}
	}
}