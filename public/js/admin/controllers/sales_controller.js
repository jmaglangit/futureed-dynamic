angular.module('futureed.controllers')
	.controller('SalesController', SalesController);

SalesController.$inject = ['$scope'];

function SalesController($scope) {
	var self = this;

	self.setActive = function(active) {
		self.errors = Constants.FALSE;

		self.active_price_settings = Constants.FALSE;
		self.active_client_discount = Constants.FALSE;
		self.active_bulk_settings = Constants.FALSE;

		switch(active) {
			case 'bulk_settings':
				self.active_bulk_settings = Constants.TRUE;
				break;

			case 'client_discount':
				self.active_client_discount = Constants.TRUE;
				break;

			case 'price_settings':
			default:
				self.active_price_settings = Constants.TRUE;
				break;
		}
	}
}