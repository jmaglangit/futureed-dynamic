angular.module('futureed.controllers')
	.controller('ManageGradeController', ManageGradeController);

ManageGradeController.$inject = ['$scope', 'apiService', 'ManageGradeService', 'TableService', 'SearchService'];

function ManageGradeController($scope, apiService, ManageGradeService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.record = {};
		self.fields = [];

		self.active_add = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_list = Constants.FALSE;

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
				self.active_list= Constants.TRUE;
				self.list();
				break;
		}

	    $("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.searchFnc = function(event) {
		self.tableDefaults();
		self.getGradeList();

		event = getEvent(event);
		event.preventDefault();
	}

	self.list = function() {
		self.getGradeList();
	}

	self.getGradeList = function() {
		self.errors = Constants.FALSE;
		self.records = {};
		self.table.loading = Constants.TRUE;

		self.search.country_id = (self.search.country_id == Constants.EMPTY_STR) ? Constants.ALL : self.search.country_id;

		$scope.ui_block();
		ManageGradeService.list(self.search, self.table).success(function(response) {
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
			self.table.loading = Constants.FALSE;
			$scope.ui_unblock();
		});
	}

	self.clear = function() {
		self.errors = Constants.FALSE;
		
		self.tableDefaults();
		self.searchDefaults();
		self.list();
	}

	self.add = function() {
		self.errors = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageGradeService.add(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_ADD);
					self.success = Constants.MSG_CREATED("Grade");
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			$scope.ui_unblock();
			self.errors = $scope.internalError();
		});
	}

	self.details = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageGradeService.details(id).success(function(response) {
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
		self.fields = [];

		$scope.ui_block();
		ManageGradeService.update(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_EDIT, self.record.id);
					self.success = Constants.MSG_UPDATED("Grade");
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.confirmDeleteGrade = function(id) {
		self.errors = Constants.FALSE;

		self.record = {};
		self.record.id = id;
		self.record.confirm = Constants.TRUE;

		$("#delete_grade_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.deleteGrade = function() {
		self.errors = Constants.FALSE;

		ManageGradeService.deleteGrade(self.record.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_LIST);
					self.success = Constants.MSG_DELETED("Grade");
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getAgeGroup = function() {
		self.ageGroup = Constants.FALSE;

		apiService.getAgeGroup().success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.ageGroup = response.data;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}
}