angular.module('futureed.controllers')
	.controller('ManageGradeController', ManageGradeController);

ManageGradeController.$inject = ['$scope', 'apiService', 'manageGradeService', 'TableService'];

function ManageGradeController($scope, apiService, manageGradeService, TableService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	self.search = {};
	self.create = {};
	self.delete = {};

	self.setManageGradeActive = setManageGradeActive;

	self.addNewGrade = addNewGrade;
	self.getGradeDetails = getGradeDetails;
	self.updateGradeDetails = updateGradeDetails;

	self.confirmDeleteGrade = confirmDeleteGrade;
	self.deleteGrade = deleteGrade;

	function setManageGradeActive(active) {
		self.errors = Constants.FALSE;

		self.search = {};
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

		$('input, select').removeClass('required-field');
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
		var grade = (self.search.grade) ? self.search.grade : Constants.EMPTY_STR;
		var country = (self.search.country) ? self.search.country : Constants.ALL;
		self.grades = {};
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		manageGradeService.getGradeList(grade, country, self.table).success(function(response) {
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
		self.search = {};

		self.tableDefaults();
		self.getGradeList();
	}

	function addNewGrade() {
		self.errors = Constants.FALSE;
		self.create.success = Constants.FALSE;
		$("input").removeClass("required-field");

		$scope.ui_block();
		manageGradeService.addNewGrade(self.create).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						$("input[name='" + value.field + "'], select[name='" + value.field + "']").addClass("required-field");
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
					self.setManageGradeActive('grade_details');
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
		self.details.success = Constants.FALSE;

		$scope.ui_block();
		manageGradeService.updateGradeDetails(self.details).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
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
}