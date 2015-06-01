angular.module('futureed.controllers')
	.controller('ManageSubjectController', ManageSubjectController);

ManageSubjectController.$inject = ['$scope', 'apiService','manageSubjectService'];

function ManageSubjectController($scope, apiService, manageSubjectService) {
	var self = this;

	self.table = {};
	self.table.size = Constants.DEFAULT_SIZE;
	self.table.page = Constants.DEFAULT_PAGE;

	self.search = {};
	self.create = {};
	self.delete = {};
	self.details = {};

	self.create_area = {};
	self.search_area = {};
	self.delete_area = {};
	self.area_details = {};
	self.errors = Constants.FALSE;

	self.setManageSubjectActive = setManageSubjectActive;

	/**
	* Subject Function Calls
	*/
	self.getSubjectList = getSubjectList;
	self.clearSearchForm = clearSearchForm;

	self.addNewSubject = addNewSubject;

	self.getSubjectDetails = getSubjectDetails;
	self.updateSubjectDetails = updateSubjectDetails;

	self.confirmDeleteSubject = confirmDeleteSubject;
	self.deleteSubject = deleteSubject;

	/**
	* Subject Area Function Calls
	*/
	self.getSubjectAreaList = getSubjectAreaList;
	self.updateSubjectAreaList = updateSubjectAreaList;
	self.clearSearchSubjectAreaForm = clearSearchSubjectAreaForm;

	self.addNewSubjectArea = addNewSubjectArea;
	
	self.getSubjectAreaDetails = getSubjectAreaDetails;
	self.updateSubjectAreaDetails = updateSubjectAreaDetails;

	self.confirmDeleteSubjectArea = confirmDeleteSubjectArea;
	self.deleteSubjectArea = deleteSubjectArea;

	function setManageSubjectActive(active) {
		self.errors = Constants.FALSE;

		self.table = {};
		self.table.size = Constants.DEFAULT_SIZE;
		self.table.page = Constants.DEFAULT_PAGE;

		self.search = {};
		self.create = {};
		self.delete = {};

		self.delete_area = {};

		self.active_subject_details = Constants.FALSE;
		self.active_add_subject = Constants.FALSE;
		self.active_list_subject = Constants.FALSE;

		self.subject_area_list = Constants.FALSE;
		self.active_subject_area_add = Constants.FALSE;
		self.active_subject_area_details = Constants.FALSE;

		switch(active) {
			case ManageSubjectConstants.VIEW_SUBJECT_ADD 			:
				self.active_add_subject = Constants.TRUE;
				break;

			case ManageSubjectConstants.VIEW_SUBJECT_DETAILS 		:
				self.active_subject_details = Constants.TRUE;
				break;

			case ManageSubjectConstants.VIEW_SUBJECT_AREA_LIST		:
				self.subject_area_list = Constants.TRUE;
				self.active_subject_area_add = Constants.TRUE;

				self.create_area.subject_id = self.subject_id;
				self.create_area.subject_name = self.subject_name;
				break;

			case ManageSubjectConstants.VIEW_SUBJECT_AREA_DETAILS	:
				self.search_area = {};
				self.subject_area_list = Constants.TRUE;
				self.active_subject_area_details = Constants.TRUE;

				self.area_details.subject_id = self.subject_id;
				self.area_details.subject_name = self.subject_name;
				break;

			case ManageSubjectConstants.VIEW_SUBJECT_LIST			:
			default:
				self.subject_id = Constants.FALSE;
				self.subject_name = Constants.FALSE;

				self.getSubjectList();
				self.active_list_subject = Constants.TRUE;
				break;
		}

		$('input, select').removeClass('required-field');
	    $("html, body").animate({ scrollTop: 0 }, "slow");
	}

	function getSubjectList() {
		self.errors = Constants.FALSE;
		self.subjects = {};
		self.table.loading = Constants.TRUE;
		var subject_name = self.search.name;

		$scope.ui_block();
		manageSubjectService.getSubjectList(subject_name, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.subjects = response.data.records;
					self.updateTable(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.table.loading = Constants.FALSE;
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function clearSearchForm() {
		self.errors = Constants.FALSE;
		self.search = {};
		self.getSubjectList();
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
					$("html, body").animate({ scrollTop: 0 }, "slow");
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function clearSearchSubjectAreaForm() {
		self.errors = Constants.FALSE;
		self.search_area = {};
		self.getSubjectAreaList(self.subject_id, self.subject_name);
	}

	function getSubjectAreaDetails(id) {
		self.errors = Constants.FALSE;
		self.area_details = {};

		$scope.ui_block();
		manageSubjectService.getSubjectAreaDetails(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.area_details = response.data;
					self.area_details.subject_id = self.subject_id;
					self.area_details.subject_name = self.subject_name;

					self.setManageSubjectActive('subject_area_details');
	    			$("html, body").animate({ scrollTop: 0 }, "slow");
				}
			}

			$scope.ui_unblock()
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function updateSubjectAreaDetails() {
		self.errors = Constants.FALSE;

		manageSubjectService.updateSubjectAreaDetails(self.area_details).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.create_area = {};
					self.create_area.subject_id = self.area_details.subject_id;
					self.create_area.subject_name = self.area_details.subject_name;

					self.area_details = {};
					self.area_details.success = Constants.TRUE;
					self.updateSubjectAreaList();
					self.setManageSubjectActive('subject_area_list');
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			$scope.ui_unblock();
			self.errors = $scope.internalError();
		});
	}

	function getSubjectAreaList(id, name) {
		self.errors = Constants.FALSE;
		self.table.loading = Constants.TRUE;
		var area_name = (self.search_area.name) ? self.search_area.name : Constants.EMPTY_STR;

		$scope.ui_block();
		manageSubjectService.getSubjectAreaList(id, area_name, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.subject_areas = response.data.records;

					self.subject_id = id;
					self.subject_name = name;

					self.create_area = {};
					self.create_area.subject_id = self.subject_id;
					self.create_area.subject_name = self.subject_name;

					self.updateTable(response.data);
					self.setManageSubjectActive('subject_area_list');
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.table.loading = Constants.FALSE;
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function updateSubjectAreaList() {
		self.errors = Constants.FALSE;
		self.subject_areas = {};
		self.table.loading = Constants.TRUE;
		var area_name = (self.search_area.name) ? self.search_area.name : Constants.EMPTY_STR;

		manageSubjectService.getSubjectAreaList(self.subject_id, area_name, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.subject_areas = response.data.records;
					self.updateTable(response.data);
	    			$("html, body").animate({ scrollTop: 0 }, "slow");
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.table.loading = Constants.FALSE;
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	function addNewSubjectArea() {
		self.errors = Constants.FALSE;
		$("input").removeClass("required-field");
		self.search_area = {};

		$scope.ui_block();
		manageSubjectService.addNewSubjectArea(self.create_area).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						$("input[name='" + value.field + "']").addClass("required-field");
					});
				} else if(response.data) {
					self.create_area.success = Constants.TRUE;
					self.create_area.code = Constants.EMPTY_STR;
					self.create_area.name = Constants.EMPTY_STR;
					self.updateSubjectAreaList();
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			$scope.ui_unblock();
			self.errors = $scope.internalError();
		});
	}

	function confirmDeleteSubjectArea(id) {
		self.errors = Constants.FALSE;

		self.delete_area.id = id;
		self.delete_area.confirm = Constants.TRUE;
		$("#delete_subject_area_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	function deleteSubjectArea(id) {
		self.errors = Constants.FALSE;
		self.create_area.success = Constants.FALSE;
		self.delete_area.success = Constants.FALSE;
		self.area_details.success = Constants.FALSE;

		manageSubjectService.deleteSubjectArea(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.delete_area.success = Constants.TRUE;
					self.updateSubjectAreaList();
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.paginateBySize = function() {
		self.table.page = 1;
		self.table.offset = (self.table.page - 1) * self.table.size;

		if(self.subject_area_list) {
			self.updateSubjectAreaList();
		} else if(self.active_list_subject) {
			self.getSubjectList();
		}
	}

	self.paginateByPage = function() {
		var page = self.table.page;
		
		self.table.page = (page < 1) ? 1 : page;
		self.table.offset = (page - 1) * self.table.size;

		if(self.subject_area_list) {
			self.updateSubjectAreaList();
		} else if(self.active_list_subject) {
			self.getSubjectList();
		}
	}

	self.updateTable = function(data) {
		self.table.total_items = data.total;

		// Set Page Count
		var page_count = data.total / self.table.size;
			page_count = (page_count < Constants.DEFAUL_PAGE) ? Constants.DEFAUL_PAGE : Math.ceil(page_count);
		self.table.page_count = page_count;
	}
}