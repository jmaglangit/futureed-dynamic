angular.module('futureed.controllers')
	.controller('ManageTipsController', ManageTipsController);

ManageTipsController.$inject = ['$scope', 'ManageTipsService', 'TableService', 'SearchService'];

function ManageTipsController($scope, ManageTipsService, TableService, SearchService) {
	var self = this;
	
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

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
				self.success = Constants.FALSE;
				self.tipDetail(id);
				self.active_edit = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST : 
			default:
				self.success = Constants.FALSE;
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
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
		self.errors = Constants.FALSE;
		self.record = {};

		$scope.ui_block();
		ManageTipsService.detail(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var record = response.data;

					self.record.id = record.id;
					self.record.module = record.module.name;
					self.record.subject = record.subject.name;
					self.record.area = record.subjectarea.name;
					self.record.link_type = record.link_type;
					self.record.title = record.title;
					self.record.content = record.content;
					self.record.status = record.status;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateTip = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageTipsService.update(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = TipConstants.MSG_UPDATE_SUCCESS;
					self.setActive(Constants.ACTIVE_VIEW, response.data.id);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}