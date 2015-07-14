angular.module('futureed.controllers')
	.controller('ManageGradeController', ManageGradeController);

ManageGradeController.$inject = ['$scope', 'apiService', 'manageGradeService', 'TableService', 'SearchService'];

function ManageGradeController($scope, apiService, manageGradeService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.create = {};
	self.delete = {};

	self.addNewGrade = addNewGrade;
	self.getGradeDetails = getGradeDetails;
	self.updateGradeDetails = updateGradeDetails;

	self.confirmDeleteGrade = confirmDeleteGrade;
	self.deleteGrade = deleteGrade;

	self.setActive = function(active) {
		self.errors = Constants.FALSE;

		self.fields = [];
		self.create = {};
		self.delete = {};

		self.active_grade_details = Constants.FALSE;
		self.active_add_grade = Constants.FALSE;
		self.active_list_grade = Constants.FALSE;

		switch(active) {
			case 'add_grade':
				self.active_add_grade = Constants.TRUE;
				break;

			case 'grade_details':
				self.active_grade_details = Constants.TRUE;
				break;

			case 'list_grade':
			default:
				self.getGradeList();
				self.active_list_grade = Constants.TRUE;
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
		self.grades = {};
		self.table.loading = Constants.TRUE;

		self.search.country_id = (self.search.country_id == Constants.EMPTY_STR) ? Constants.ALL:self.search.country_id;

		$scope.ui_block();
		manageGradeService.getGradeList(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.grades = response.data.records;
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
		
		self.tableDefaults();
		self.searchDefaults();
		self.getGradeList();
	}

	function addNewGrade() {
		self.errors = Constants.FALSE;
		self.create.success = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		manageGradeService.addNewGrade(self.create).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.create = {};
					self.create.success = Constants.TRUE;
	    			$("html, body").animate({ scrollTop: 0 }, "slow");
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			$scope.ui_unblock();
			self.errors = $scope.internalError();
		});
	}

	function getGradeDetails(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		manageGradeService.getGradeDetails(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.details = response.data;
					self.setActive('grade_details');
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});	
	}

	function updateGradeDetails() {
		self.errors = Constants.FALSE;
		self.fields = [];
		self.details.success = Constants.FALSE;

		$scope.ui_block();
		manageGradeService.updateGradeDetails(self.details).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.details.success = Constants.TRUE;
	    			$("html, body").animate({ scrollTop: 0 }, "slow");
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function confirmDeleteGrade(id) {
		self.errors = Constants.FALSE;

		self.delete.id = id;
		self.delete.confirm = Constants.TRUE;
		$("#delete_grade_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	function deleteGrade(id) {
		self.errors = Constants.FALSE;

		manageGradeService.deleteGrade(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.delete.success = Constants.TRUE;
					self.getGradeList();
					$("html, body").animate({ scrollTop: 0 }, "slow");
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