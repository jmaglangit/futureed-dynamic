angular.module('futureed.controllers')
	.controller('StudentPaymentController', StudentPaymentController);

StudentPaymentController.$inject = ['$scope', 'apiService', 'StudentPaymentService', 'SearchService', 'TableService'];

function StudentPaymentController($scope, apiService, StudentPaymentService, SearchService, TableService) {

	var self = this;

	SearchService(self);
	self.searchDefaults();

	TableService(self);
	self.tableDefaults();

	self.setActive = function(active) {
		self.errors = Constants.FALSE;

		self.active_list = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_LIST 	:

			default:
				self.active_list = Constants.TRUE;
				break;
		}
	}

	self.searchFnc = function(event) {
		self.tableDefaults();
		self.listPayments();
		
		event = getEvent(event);
		event.preventDefault();
	}

	self.clear = function() {
		self.searchDefaults();
		self.listPayments();
	}

	self.list = function() {
		self.listPayments();
	}

	self.listPayments = function() {
		self.errors = Constants.FALSE;
		
		self.table.size = 5;
		self.search.student_id = $scope.user.id;

		$scope.ui_block();
		StudentPaymentService.list(self.search, self.table).success(function(response) {
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

		StudentPaymentService.listSubscription().success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.subscriptions = response.data.records;
					console.log(self.subscriptions);
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}
}