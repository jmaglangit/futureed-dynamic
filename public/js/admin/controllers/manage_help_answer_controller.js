angular.module('futureed.controllers')
	.controller('ManageHelpAnswerController', ManageHelpAnswerController);

ManageHelpAnswerController.$inject = ['$scope', 'ManageHelpAnswerService', 'TableService', 'SearchService'];

function ManageHelpAnswerController($scope, ManageHelpAnswerService, TableService, SearchService) {
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
				self.answerDetail(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT :
				self.success = Constants.FALSE;
				self.answerDetail(id);
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
		self.success = Constants.FALSE;

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
			self.listAnswers();
		}
	}

	self.listAnswers = function() {
		self.errors = Constants.FALSE;
		self.records = [];
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageHelpAnswerService.list(self.search, self.table).success(function(response) {
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

	self.answerDetail = function(id) {
		self.errors = Constants.FALSE;
		self.record = {};

		$scope.ui_block();
		ManageHelpAnswerService.detail(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var record = response.data;

					self.record.id = record.id;
					self.record.module = (record.module) ? record.module.name : Constants.EMPTY_STR;
					self.record.subject = (record.subject) ? record.subject.name : Constants.EMPTY_STR;
					self.record.area = (record.subject_area) ? record.subject_area.name : Constants.EMPTY_STR;
					
					self.record.link_type = record.help_request.link_type;
					self.record.request_answer_status = record.request_answer_status;
					self.record.title = record.help_request.title;
					self.record.content = record.content;
					self.record.status = record.status;
					self.record.name = record.user.name;
					self.record.rated_by = record.rated_by;
					self.record.stars = new Array(5);
					self.record.rating = record.rating;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateHelpAnswer = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageHelpAnswerService.update(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.success = HelpAnswerConstants.MSG_UPDATE_SUCCESS;
					self.setActive(Constants.ACTIVE_VIEW, response.data.id);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.rateAnswer = function() {
		self.rate_modal = Constants.TRUE;
		$("#rate_answer").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.acceptAnswer = function() {
		var data = {};
			data.id = self.record.id;
			data.rated_by = Constants.ADMIN;
			data.rating = self.rating;
			data.request_answer_status = "Accepted";
			data.message = HelpAnswerConstants.MSG_ACCEPT_ANSWER_SUCCESS;

		updateHelpAnswerStatus(data);
	}

	self.rejectAnswer = function() {
		var data = {};
			data.id = self.record.id;
			data.request_answer_status = "Rejected";
			data.message = HelpAnswerConstants.MSG_REJECT_ANSWER_SUCCESS;

		updateHelpAnswerStatus(data);
	}

	function updateHelpAnswerStatus(data) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageHelpAnswerService.updateHelpAnswerStatus(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.rate_errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					$("#rate_answer").modal('hide');
					self.success = data.message;
					self.setActive(Constants.ACTIVE_VIEW, response.data.id);
					self.rate_errors = Constants.FALSE;
					self.rating = Constants.EMPTY_STR
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

	self.deleteAnswer = function() {
		$scope.ui_block();
		ManageHelpAnswerService.delete(self.confirm.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = HelpAnswerConstants.MSG_DELETE_SUCCESS;
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