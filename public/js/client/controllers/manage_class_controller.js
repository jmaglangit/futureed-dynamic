angular.module('futureed.controllers')
	.controller('ManageClassController', ManageClassController);

ManageClassController.$inject = ['$scope', 'manageClassService', 'apiService', 'TableService', 'SearchService'];

function ManageClassController($scope, manageClassService, apiService, TableService, SearchService) {
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
			case Constants.ACTIVE_VIEW	:
				self.details(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT	:
				self.success = Constants.FALSE;
				self.details(id);
				self.active_edit = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST	:
			default:
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.searchFnc = function() {
		self.list();
	}

	self.clear = function() {
		self.searchDefaults();
		self.list();
	}

	self.list = function() {
		self.errors = Constants.FALSE;
		self.search.client_id = $scope.user.id;

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

	self.details = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		manageClassService.details(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.record = response.data;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.update = function() {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		manageClassService.update(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = TeacherConstant.UPDATE_CLASSNAME_SUCCESS;
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}