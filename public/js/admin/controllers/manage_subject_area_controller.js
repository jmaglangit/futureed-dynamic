angular.module('futureed.controllers')
	.controller('ManageSubjectAreaController', ManageSubjectAreaController);

ManageSubjectAreaController.$inject = ['$scope', 'apiService','manageSubjectAreaService', 'TableService'];

function ManageSubjectAreaController($scope, apiService, manageSubjectAreaService, TableService) {
	var self = this;
	self.errors = Constants.FALSE;

	//Table Services
	TableService(self);
	self.tableDefaults();

	self.records = {};
	self.record = {};
	self.delete = {};

	self.search = {};
	self.search.name = Constants.EMPTY_STR;

	self.setActive = function(active) {
		self.errors = Constants.FALSE;
		self.tableDefaults();

		self.records = {};
		self.record.subject_id = $scope.getSubjectId();
		self.record.subject_name = $scope.getSubjectName();

		self.search = {};
		self.search.name = Constants.EMPTY_STR;

		$scope.subject_area_list = Constants.FALSE;

		self.active_list = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_details = Constants.FALSE;

		switch(active) {
			case "add_subject_area"	:
				self.success = Constants.FALSE;
				self.active_add = Constants.TRUE;
				break;

			case ManageSubjectConstants.VIEW_SUBJECT_AREA_DETAILS	:
				self.success = Constants.FALSE;
				self.active_details = Constants.TRUE;
				break;

			case ManageSubjectConstants.VIEW_SUBJECT_AREA_LIST			:
			default:
				self.success = Constants.FALSE;
				self.active_list = Constants.TRUE;
				self.list();
				break;
		}

		$('input, select').removeClass('required-field');
	    $("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.list = function() {
		self.errors = Constants.FALSE;
		self.search.subject_id = self.record.subject_id;
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		manageSubjectAreaService.list(self.search, self.table).success(function(response) {
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


	self.clear = function() {
		self.errors = Constants.FALSE;

		self.search = {};
		self.search.name = Constants.EMPTY_STR;

		self.list();
	}

	self.details = function(id) {
		self.errors = Constants.FALSE;
		self.record = {};

		$scope.ui_block();
		manageSubjectAreaService.details(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.record = response.data;
					self.setActive(ManageSubjectConstants.VIEW_SUBJECT_AREA_DETAILS);
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

		manageSubjectAreaService.update(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = Constants.EDIT_AREA_SUCCESS;
					self.setActive(ManageSubjectConstants.VIEW_SUBJECT_AREA_DETAILS);
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

		$("input").removeClass("required-field");
		$scope.ui_block();
		manageSubjectAreaService.add(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						$("input[name='" + value.field + "']").addClass("required-field");
					});
				} else if(response.data) {
					self.success = Constants.ADD_AREA_SUCCESS;
					self.setActive('add_subject_area');
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
		self.record.confirm = Constants.TRUE;
		$("#delete_subject_area_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.delete = function() {
		self.errors = Constants.FALSE;

		manageSubjectAreaService.delete(self.record.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = Constants.DELETE_AREA_SUCCESS;
					self.setActive();
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}