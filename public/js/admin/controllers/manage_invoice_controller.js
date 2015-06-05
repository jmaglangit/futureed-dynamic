angular.module('futureed.controllers')
	.controller('ManageInvoiceController', ManageInvoiceController);

ManageInvoiceController.$inject = ['$scope', 'manageInvoiceService', 'apiService', 'TableService', 'SearchService'];

function ManageInvoiceController($scope, manageInvoiceService, apiService, TableService, SearchService) {

	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active){
		self.errors = Constants.FALSE;

		self.active_list = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_LIST:
			default:
				self.active_list = Constants.TRUE;
				break

		}
	}

	self.searchFnc = function() {
		self.errors = Constants.FALSE;

		self.list();
	}

	self.clear = function() {
		self.errors = Constants.FALSE;

		self.searchDefaults();
		self.list();
	}

	self.list = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		manageInvoiceService.list(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.record;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError()
			$scope.ui_unblock();
		});
	}
}