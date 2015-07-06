angular.module('futureed.controllers')
	.controller('TipsController', TipsController);

TipsController.$inject = ['$scope', 'apiService', 'StudentTipsService', 'TableService', 'SearchService'];

function TipsController($scope, apiService, StudentTipsService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active) {
		self.errors = Constants.FALSE;

		self.active_list = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_LIST:
				self.active_list = Constants.TRUE;
				break;

			default:
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.searchFnc = function(event) {
		self.success = Constants.FALSE;

		self.tableDefaults();
		self.list();

		event = getEvent(event);
		event.preventDefault();
	}

	self.clearFnc = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.searchDefaults();
		self.tableDefaults();

		self.list();
	}

	self.list = function() {
		if(self.active_list) {
			self.listTips();
		}
	}

	self.listTips = function() {
		self.records = [];
		self.errors = Constants.FALSE;
		self.search.class_id = $scope.user.class_id;
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		StudentTipsService.list(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

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

}
