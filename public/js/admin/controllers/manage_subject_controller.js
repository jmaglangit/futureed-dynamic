angular.module('futureed.controllers')
	.controller('ManageSubjectController', ManageSubjectController);

ManageSubjectController.$inject = ['$scope', 'apiService','manageSubjectService'];

function ManageSubjectController($scope, apiService, manageSubjectService) {
	var self = this;

	self.search = {};
	self.create = {};
	self.delete = {};
	self.details = {};
	self.errors = Constants.FALSE;

	self.setManageSubjectActive = setManageSubjectActive;
	self.getSubjectList = getSubjectList;
	self.clearSearchForm = clearSearchForm;

	self.getSubjectDetails = getSubjectDetails;
	self.updateSubjectDetails = updateSubjectDetails;

	self.addNewSubject = addNewSubject;

	self.confirmDeleteSubject = confirmDeleteSubject;
	self.deleteSubject = deleteSubject;

	function setManageSubjectActive(active) {
		self.errors = Constants.FALSE;

		self.active_subject_details = Constants.FALSE;
		self.active_add_subject = Constants.FALSE;
		self.active_list_subject = Constants.FALSE;

		switch(active) {
			case 'add_subject':
				self.active_add_subject = Constants.TRUE;
				break;

			case 'subject_details':
				self.active_subject_details = Constants.TRUE;
				break;

			case 'list_subject':
			default:
				self.getSubjectList();
				self.active_list_subject = Constants.TRUE;
				break;
		}

		$('input, select').removeClass('required-field');
	    $("html, body").animate({ scrollTop: 0 }, "slow");
	}

	function clearSearchForm() {
		self.errors = Constants.FALSE;
		self.search = {};
		self.getSubjectList();
	}

	function getSubjectList() {
		self.errors = Constants.FALSE;
		var subject_name = self.search.name;

		$scope.ui_block();
		manageSubjectService.getSubjectList(subject_name).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.subjects = response.data.records;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			$scope.ui_unblock();
			self.errors = $scope.internalError();
		});
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
					self.delete.success = Constants.TRUE;
					self.getSubjectList();
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});

	}
}