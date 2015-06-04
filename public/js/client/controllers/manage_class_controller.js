angular.module('futureed.controllers')
	.controller('ManageClassController', ManageClassController);

ManageClassController.$inject = ['$scope', 'manageClassService', 'apiService', 'TableService', 'SearchService'];

function ManageClassController($scope, manageClassService, apiService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active) {

		self.active_list = Constants.FALSE;
		switch(active) {
			case Constants.ACTIVE_LIST	:
			default:
				self.active_list = Constants.TRUE;
				break;
		}
	}

	self.list = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		manageClassService.list(self.search, self.table).success(function(response) {
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
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.searchFnc = function() {
		self.list();
	}

	self.clear = function() {
		self.searchDefaults();
		self.list();
	}
}