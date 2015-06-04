angular.module('futureed.controllers')
	.controller('ManageParentPaymentController', ManageParentPaymentController);

ManageParentPaymentController.$inject = ['$scope', 'ManageParentPaymentService', 'apiService'];

function ManageParentPaymentController($scope, ManageParentPaymentService, apiService) {
	var self = this;
	
	self.setActive = setActive;

	function setActive(req)
	{
		self.errors = Constants.FALSE;

		switch(req){

			case 'add':
			self.add = Constants.TRUE;
			self.list = Constants.FALSE;
			break

			case 'list':
			default:
			self.list = Constants.TRUE;
			self.add = Constants.FALSE;
			break
		}
	$("html, body").animate({ scrollTop: 0 }, "slow");
	}
}