angular.module('futureed.controllers')
	.controller('ManageSubjectAreaController', ManageSubjectAreaController);

ManageSubjectAreaController.$inject = ['$scope', 'apiService','ManageSubjectAreaService', 'TableService', 'SearchService'];

function ManageSubjectAreaController($scope, apiService, ManageSubjectAreaService, TableService, SearchService) {
	var self = this;

	var subject_id = Constants.EMPTY_STR;
	var subject_name = Constants.EMPTY_STR;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.record = {};
		self.record.subject_id = subject_id;
		self.record.subject_name = subject_name;
		
		self.fields = [];

		self.tableDefaults();
		self.searchDefaults();

		self.active_list = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		
		subject_id = $scope.getSubjectId();
		subject_name = $scope.getSubjectName();

		switch(active) {
			case Constants.ACTIVE_ADD	:
				self.active_add = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT	:
				self.active_edit = Constants.TRUE;
				self.details(id);
				break;

			case Constants.ACTIVE_LIST	:
			default:
				self.active_list = Constants.TRUE;
				self.list();
				break;
		}

	    $("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.list = function() {
		self.errors = Constants.FALSE;
		self.records = {};

		self.search.subject_id = subject_id;
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageSubjectAreaService.list(self.search, self.table).success(function(response) {
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
			self.table.loading = Constants.FALSE;
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.searchFnc = function(event) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.tableDefaults();
		self.list();

		event = getEvent(event);
		event.preventDefault();
	}

	self.clear = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.tableDefaults();
		self.searchDefaults();

		self.list();
	}

	self.details = function(id) {
		self.errors = Constants.FALSE;
		self.record = {};

		$scope.ui_block();
		ManageSubjectAreaService.details(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.record = response.data;
					self.record.subject_name = subject_name;
				}
			}

			$scope.ui_unblock()
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.update = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageSubjectAreaService.update(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_EDIT, self.record.id);
					self.success = Constants.MSG_UPDATED("Subject area");
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.add = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageSubjectAreaService.add(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_ADD);
					self.success = Constants.MSG_CREATED("Subject area");
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.confirmDelete = function(id) {
		self.errors = Constants.FALSE;

		self.record = {};
		self.record.id = id;
		self.record.subject_id = subject_id;
		self.record.subject_name = subject_name;
		self.record.confirm = Constants.TRUE;

		$("#delete_subject_area_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.delete = function() {
		self.errors = Constants.FALSE;

		ManageSubjectAreaService.delete_area(self.record.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.setActive();
					self.success = Constants.MSG_DELETED("Subject area");
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}