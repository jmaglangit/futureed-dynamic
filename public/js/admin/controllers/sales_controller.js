angular.module('futureed.controllers')
	.controller('SalesController', SalesController);

SalesController.$inject = ['$scope'];

function SalesController($scope) {
	var self = this;

	self.setActive = function(active) {
		self.errors = Constants.FALSE;

		self.active_client_discount = Constants.FALSE;
		self.active_bulk_settings = Constants.FALSE;
		self.active_subscription = Constants.FALSE;
		self.active_subscription_days = Constants.FALSE;
		self.active_subscription_packages = Constants.FALSE;

		switch(active) {
			case Constants.BULK_SETTINGS:
				self.active_bulk_settings = Constants.TRUE;
				break;

			case Constants.CLIENT_DISCOUNT:
				self.active_client_discount = Constants.TRUE;
				break;

			case Constants.SUBSCRIPTION_DAYS:
				self.active_subscription_days = Constants.TRUE;
				break;

			case Constants.SUBSCRIPTION_PACKAGES:
				self.active_subscription_packages = Constants.TRUE;
				break;

			case Constants.SUBSCRIPTION:
			default:
				self.active_subscription = Constants.TRUE;
				break;
		}
	}
}