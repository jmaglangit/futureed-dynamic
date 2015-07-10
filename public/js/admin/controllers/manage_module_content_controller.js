angular.module('futureed.controllers')
	.controller('ManageModuleContentController', ManageModuleContentController);

ManageModuleContentController.$inject = ['$scope', 'ManageModuleContentService', 'TableService', 'SearchService'];

function ManageModuleContentController($scope, ManageModuleContentService, TableService, SearchService) {
	var self = this;
	
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setModule = function (data) {
		self.module = {};
		self.module.id = data.id;	
		self.module.name = data.name;	
		self.module.subject = {};
		self.module.subject.id = data.subject.id;	
		self.module.subject.name = data.subject.name;	
		self.module.subject_area = {};
		self.module.subject_area.id = data.subjectarea.id;
		self.module.subject_area.name = data.subjectarea.name;
	}

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.fields = [];

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_add = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_ADD :
				self.record = {};

				self.record.module_id = self.module.id;
				self.record.subject_id = self.module.subject.id;
				self.record.subject_area_id = self.module.subject_area.id;
				self.record.module = self.module.name;
				self.record.subject = self.module.subject.name;
				self.record.subject_area = self.module.subject_area.name;

				self.success = Constants.FALSE;
				self.active_add = Constants.TRUE;
				break;

			case Constants.ACTIVE_VIEW :
				self.contentDetail(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT :
				self.success = Constants.FALSE;
				self.contentDetail(id);
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
			self.listContents();
		}
	}

	self.getLearningStyle = function() {
		ManageModuleContentService.getLearningStyle().success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.styles = response.data.records;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.getMediaTypes = function() {
		ManageModuleContentService.getMediaTypes().success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.types = response.data.records;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.listContents = function() {
		self.errors = Constants.FALSE;
		self.records = [];
		self.search.teaching_module_id = self.module.id;
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageModuleContentService.list(self.search, self.table).success(function(response) {
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

	self.contentDetail = function(id) {
		self.errors = Constants.FALSE;
		self.record = {};

		$scope.ui_block();
		ManageModuleContentService.detail(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var record = response.data;

					self.record.id = record.id;
					self.record.module = (record.module) ? record.module.name : Constants.EMPTY_STR;
					self.record.subject = (record.subject) ? record.subject.name : Constants.EMPTY_STR;
					self.record.area = (record.subject_area) ? record.subject_area.name : Constants.EMPTY_STR;

					self.record.code = record.code;
					self.record.teaching_module = record.teaching_module;
					self.record.description = record.description;
					self.record.content_url = record.content_url;
					self.record.learning_style_id = record.learning_style.id;
					self.record.media_type_id = record.media_type.id;
					self.record.status = record.status;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.addContent = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageModuleContentService.add(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.success = ContentConstants.MSG_ADD_SUCCESS;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateContent = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageModuleContentService.update(self.record).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.success = ContentConstants.MSG_UPDATE_SUCCESS;
					self.setActive(Constants.ACTIVE_VIEW, response.data.id);
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

	self.deleteContent = function() {
		$scope.ui_block();
		ManageModuleContentService.delete(self.confirm.id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = ContentConstants.MSG_DELETE_SUCCESS;
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