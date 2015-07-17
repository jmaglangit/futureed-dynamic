angular.module('futureed.controllers')
	.controller('ManageHelpRequestController', ManageHelpRequestController);

ManageHelpRequestController.$inject = ['$scope', 'ManageHelpRequestService', 'TableService', 'SearchService'];

function ManageHelpRequestController($scope, ManageHelpRequestService, TableService, SearchService) {
	var self = this;
	
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.fields = [];

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch(active) {

			case Constants.ACTIVE_VIEW :
				self.helpDetail(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT :
				self.success = Constants.FALSE;
				self.helpDetail(id);
				self.active_edit = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST : 
				self.active_list = Constants.TRUE;
				
				self.searchDefaults();
				self.tableDefaults();
				self.list();
				break;

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
			self.listHelp();
		}
	}

	self.listHelp = function() {
		self.errors = Constants.FALSE;
		self.records = [];
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageHelpRequestService.list(self.search, self.table).success(function(response) {
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

	self.helpDetail = function(id) {
		self.errors = Constants.FALSE;
		self.record = {};

		$scope.ui_block();
		ManageHelpRequestService.detail(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var record = response.data;

					self.record.id = record.id;
					self.record.module = (record.module) ? record.module.name : Constants.EMPTY_STR;
					self.record.subject = (record.subject) ? record.subject.name : Constants.EMPTY_STR;
					self.record.area = (record.subject_area) ? record.subject_area.name : Constants.EMPTY_STR;

					self.record.link_type = record.link_type;
					self.record.title = record.title;
					self.record.content = record.content;
					self.record.status = record.status;
					self.record.request_status = record.request_status;
					self.record.name = record.student.first_name + ' ' + record.student.last_name;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateHelp = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageHelpRequestService.update(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.success = HelpConstants.MSG_UPDATE_SUCCESS;
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.acceptHelp = function() {
		var data = {};
			data.id = self.record.id;
			data.request_status = "Accepted";
			data.message = HelpConstants.MSG_ACCEPT_HELP_SUCCESS;

		updateHelpStatus(data);
	}

	self.rejectHelp = function() {
		var data = {};
			data.id = self.record.id;
			data.request_status = "Rejected";
			data.message = HelpConstants.MSG_REJECT_HELP_SUCCESS;

		updateHelpStatus(data);
	}

	function updateHelpStatus(data) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageHelpRequestService.updateHelpStatus(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = data.message;
					self.setActive(Constants.ACTIVE_VIEW, data.id);
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
		self.success = Constants.FALSE;
		
		self.confirm = {};
		self.confirm.id = id;
		self.confirm.delete = Constants.TRUE;

		$("#delete_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.deleteHelp = function() {
		$scope.ui_block();
		ManageHelpRequestService.delete(self.confirm.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = HelpConstants.MSG_DELETE_SUCCESS;
					self.setActive(Constants.ACTIVE_LIST);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}