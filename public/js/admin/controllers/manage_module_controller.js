angular.module('futureed.controllers')
	.controller('ManageModuleController', ManageModuleController);

ManageModuleController.$inject = ['$scope', 'manageModuleService', 'apiService', 'TableService', 'SearchService'];

function ManageModuleController($scope, manageModuleService, apiService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, id) {
		console.log(active)
		self.errors = Constants.FALSE;

		self.active_list = Constants.FALSE;

		switch (active) {
			default:
				self.active_list = Constants.TRUE;
				break;
		}
	}

	self.searchFnc = function(event) {
		self.errors = Constants.FALSE;
		self.list();
		
		event = getEvent(event);
		event.preventDefault();
	}

	self.clearFnc = function() {
		self.errors = Constants.FALSE;

		self.searchDefaults();
		self.list();
	}

	self.list = function() {
		self.errors = Constants.FALSE;
		self.records = {};
		self.table.loading = Constants.TRUE;
		$scope.ui_block();

		manageModuleService.list(self.search, self.table).success(function(response){
			self.table.loading = Constants.FALSE;
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.records = response.data.records;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}