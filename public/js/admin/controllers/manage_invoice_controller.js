angular.module('futureed.controllers')
	.controller('ManageInvoiceController', ManageInvoiceController);

ManageInvoiceController.$inject = ['$scope', 'manageInvoiceService', 'apiService', 'TableService', 'SearchService'];

function ManageInvoiceController($scope, manageInvoiceService, apiService, TableService, SearchService) {

	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, invoice_no){
		self.errors = Constants.FALSE;
		self.fields = [];

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_VIEW:
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT:
				self.success = Constants.FALSE;
				self.active_edit = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST:
			default:
				self.success = Constants.FALSE;
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.searchFnc = function(event) {
		self.errors = Constants.FALSE;
		self.list();
		
		event = getEvent(event);
		event.preventDefault();
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
					self.records = response.data.records;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError()
			$scope.ui_unblock();
		});
	}

	self.details = function(invoice_no, active) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		manageInvoiceService.details(invoice_no).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.record = response.data;
					self.setActive(active);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateStatus = function() {
		self.fields = [];
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		manageInvoiceService.updateStatus(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.success = Constants.UPDATE_PAYMENT_STATUS_SUCCESS;
					self.setActive(Constants.ACTIVE_VIEW);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}