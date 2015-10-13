angular.module('futureed.controllers')
	.controller('ManageSubjectController', ManageSubjectController);

ManageSubjectController.$inject = ['$scope', 'apiService','manageSubjectService', 'TableService', 'SearchService'];

function ManageSubjectController($scope, apiService, manageSubjectService, TableService, SearchService) {
	var self = this;

	//Table Services
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.create = {};
	self.delete = {};
	self.details = {};

	self.create_area = {};
	self.search_area = {};
	self.delete_area = {};
	self.area_details = {};

	/**
	* Subject Function Calls
	*/
	self.addNewSubject = addNewSubject;

	self.getSubjectDetails = getSubjectDetails;
	self.updateSubjectDetails = updateSubjectDetails;

	self.confirmDeleteSubject = confirmDeleteSubject;
	self.deleteSubject = deleteSubject;

	self.setManageSubjectActive = function(active) {
		self.errors = Constants.FALSE;

		self.tableDefaults();
		self.searchDefaults();
	
		self.create = {};
		self.delete = {};

		self.active_subject_details = Constants.FALSE;
		self.active_add_subject = Constants.FALSE;
		self.active_list_subject = Constants.FALSE;

		switch(active) {
			case ManageSubjectConstants.VIEW_SUBJECT_ADD 			:
				self.active_add_subject = Constants.TRUE;
				break;

			case ManageSubjectConstants.VIEW_SUBJECT_DETAILS 		:
				self.active_subject_details = Constants.TRUE;
				break;

			case ManageSubjectConstants.VIEW_SUBJECT_AREA_LIST		:
				$scope.subject_area_list = Constants.TRUE;
				break;

			case ManageSubjectConstants.VIEW_SUBJECT_LIST			:
			default:
				self.list();
				self.active_list_subject = Constants.TRUE;
				$scope.list_subject = Constants.TRUE;
				break;
		}

		$('input, select').removeClass('required-field');
	    $("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.searchFnc = function(event) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.tableDefaults();
		self.list();

		event = getEvent(event);
		event.preventDefault();
	}

	self.list = function() {
		self.errors = Constants.FALSE;
		self.subjects = {};
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		manageSubjectService.getSubjectList(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.subjects = response.data.records;
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
		self.searchDefaults();
		self.tableDefaults();

		self.list();
	}

	function addNewSubject() {
		self.errors = Constants.FALSE;
		self.create.success = Constants.FALSE;
		$("input").removeClass("required-field");

		$scope.ui_block();
		manageSubjectService.addNewSubject(self.create).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						$("input[name='" + value.field + "']").addClass("required-field");
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

	function updateSubjectDetails() {
		self.errors = Constants.FALSE;
		self.details.success = Constants.FALSE;

		$scope.ui_block();
		manageSubjectService.updateSubjectDetails(self.details).success(function(response) {
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

	function getSubjectDetails(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		manageSubjectService.getSubjectDetails(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.details = response.data;
					self.setManageSubjectActive('subject_details');
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});	
	}

	function confirmDeleteSubject(id) {
		self.errors = Constants.FALSE;

		self.delete.id = id;
		self.delete.confirm = Constants.TRUE;
		$("#delete_subject_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	function deleteSubject(id) {
		self.errors = Constants.FALSE;

		manageSubjectService.deleteSubject(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = ManageSubjectConstants.DELETE_SUBJECT_SUCCESS;
					self.list();

					$("html, body").animate({ scrollTop: 0 }, "slow");
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.setSubjectAreaDetails = function(id, name) {
		self.subject_id = id;
		self.subject_name = name;

		self.setManageSubjectActive(ManageSubjectConstants.VIEW_SUBJECT_AREA_LIST);
	}

	$scope.getSubjectId = function() {
		return self.subject_id;
	}

	$scope.getSubjectName = function() {
		return self.subject_name;
	}
}