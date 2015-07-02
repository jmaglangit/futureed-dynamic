angular.module('futureed.controllers')
	.controller('ManageTipsController', ManageTipsController);

ManageTipsController.$inject = ['$scope', 'ManageTipsService', 'TableService', 'SearchService'];

function ManageTipsController($scope, ManageTipsService, TableService, SearchService) {
	var self = this;
	
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	// TODO: delete if API is OK. Dummy data just to show view / edit icons in list
	self.records = [{
		asd : 'asd'
	}];

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch(active) {

			case Constants.ACTIVE_VIEW :
				self.tipDetail(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT :
				self.tipDetail(id);
				self.active_edit = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST : 
			default:
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.updateTip = function() {
		self.setActive(Constants.ACTIVE_VIEW);
	}

	self.searchFnc = function(event) {
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
		self.errors = Constants.FALSE;
		self.records = [];
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageTipsService.list(self.search, self.table).success(function(response) {
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

	self.tipDetail = function(id) {
		
	}
}