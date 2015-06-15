angular.module('futureed.controllers')
	.controller('ManagePrincipalPaymentController', ManagePrincipalPaymentController);

ManagePrincipalPaymentController.$inject = ['$scope', 'managePrincipalPaymentService', 'apiService', 'TableService', 'SearchService'];

function ManagePrincipalPaymentController($scope, managePrincipalPaymentService, apiService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_list = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_LIST:
			default:
				self.active_list = Constants.TRUE;
				break;
		}
	}

	self.list = function() {
		if(self.active_list) {
			self.listPayments();
		}
	}

	self.searchFnc = function() {
		self.listPayments();
	}

	self.clear = function() {
		self.searchDefaults();
		self.listPayments();
	}

	self.listPayments = function() {
		self.errors = Constants.FALSE;
		self.search.client_id = $scope.user.id;

		$scope.ui_block();
		managePrincipalPaymentService.list(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.records;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.listSubscription = function() {
		self.subscriptions = [];

		managePrincipalPaymentService.listSubscription().success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.subscriptions = response.data.records;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}
}