angular.module('futureed.controllers')
	.controller('ManageLogsController', ManageLogsController);

ManageLogsController.$inject = ['$scope', 'ManageLogsService', 'TableService', 'SearchService'];

function ManageLogsController($scope, ManageLogsService, TableService, SearchService) {
	var self = this;
	
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active) {
		self.errors = Constants.FALSE;

		self.active_list = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_LIST :

			default:
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.list = function() {
		ManageLogsService.list(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.headers = response.data.column_header;
					self.records = response.data.rows;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}
}