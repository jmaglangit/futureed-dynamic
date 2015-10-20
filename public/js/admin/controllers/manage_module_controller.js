angular.module('futureed.controllers')
	.controller('ManageModuleController', ManageModuleController);

ManageModuleController.$inject = ['$scope', 'ManageModuleService', 'TableService', 'SearchService', 'Upload'];

function ManageModuleController($scope, ManageModuleService, TableService, SearchService, Upload) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.validation = {};
		self.record = {};
		self.fields = [];

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		self.tableDefaults();
		self.searchDefaults();

		switch (active) {
			case Constants.ACTIVE_EDIT:
				self.active_edit = Constants.TRUE;
				self.details(id);
				break;

			case Constants.ACTIVE_VIEW :
				self.active_view = Constants.TRUE;
				self.details(id);

				self.detail_hidden = Constants.FALSE;
				self.content_hidden = Constants.TRUE;
				break;

			case Constants.ACTIVE_ADD : 
				self.active_add = Constants.TRUE;
				break;

			default:
				self.active_list = Constants.TRUE;
				self.list();
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.toggleDetail = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		var detail_shown = $('#module_detail').hasClass('in');

		if(detail_shown) {
			self.detail_hidden = Constants.TRUE;
		} else {
			self.detail_hidden = Constants.FALSE;
			self.content_hidden = Constants.TRUE;
		}
	}

	self.toggleContent = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		var content_shown = $('#module_tabs').hasClass('in');
		
		if(content_shown) {
			self.content_hidden = Constants.TRUE;
		} else {
			self.content_hidden = Constants.FALSE;
			self.detail_hidden = Constants.TRUE;

			if(!self.details.current_view) {
				self.setActiveContent(Constants.AGEGROUP)
			}
		}
	}

	self.setActiveContent = function(view) {
		self.record.current_view = view;
	}

	self.searchFnc = function(event) {
		self.errors = Constants.FALSE;
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
		self.errors = Constants.FALSE;
		self.records = [];

		self.table.loading = Constants.TRUE;
		
		$scope.ui_block();
		ManageModuleService.list(self.search, self.table).success(function(response){
			self.table.loading = Constants.FALSE;
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.records = response.data.records;
					self.updatePageCount(response.data);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.add = function(){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.validation = {};

		self.areas = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageModuleService.add(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_ADD);
					self.success = Constants.MSG_CREATED("Module");
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getSubject = function() {
		$scope.ui_block();
		ManageModuleService.getSubject().success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.subjects = response.data.records;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.setSubject = function() {
		self.record.subject_area_id = Constants.EMPTY_STR;
		self.record.area = Constants.EMPTY_STR;
		self.areas = Constants.FALSE;
	}

	self.searchArea = function() {
		self.validation = {};
		self.validation.s_loading = Constants.TRUE;

		ManageModuleService.searchArea(self.record.subject_id, self.record.area).success(function(response){
			self.validation.s_loading = Constants.FALSE;
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.data) {
					if(response.data.records.length == 0) {
						if(area == ''){
							self.validation = {};
						}else{
							self.validation.s_error = ManageModuleConstants.NO_AREA;
						}
					}else {
						self.areas = response.data.records;
					}
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	self.selectArea = function(area) {
		self.record.subject_area_id = area.id;
		self.record.area = area.name;

		self.areas = Constants.FALSE;
	}

	self.details = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageModuleService.details(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.record = response.data;
					self.record.area = (self.record.subjectarea) ? self.record.subjectarea.name : Constants.EMPTY_STR;
				}
			}
		$scope.ui_unblock();
		}).error(function(response) {
			self.errors = internalError();
			$scope.ui_unblock();
		});
	}

	self.update = function(){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.validation = {};
		
		self.areas = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageModuleService.update(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
	    			self.success = Constants.MSG_UPDATED("Module");
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.confirmDelete = function(id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.record = {};
		self.record.id = id;
		self.record.confirm = Constants.TRUE;

		$("#delete_module_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.deleteModule = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageModuleService.deleteModule(self.record.id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_LIST);
					self.success = Constants.MSG_DELETED("Module");
				}
			}

			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.upload = function(file, object) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		
    	object.uploaded = Constants.FALSE;

		if(file.length) {
			$scope.ui_block();
			Upload.upload({
                url: '/api/v1/module/icon'
                , file: file[0]
            }).success(function(response) {
                if(angular.equals(response.status, Constants.STATUS_OK)) {
	                if(response.errors) {
	                    self.errors = $scope.errorHandler(response.errors);
	                }else if(response.data){
                		object.image = response.data.image_name;
                		object.uploaded = Constants.TRUE;
                		self.image = object.image;
	                }
	            }

            	$scope.ui_unblock();
            }).error(function(response) {
                self.errors = $scope.internalError();
                $scope.ui_unblock();
            });
        }
	}

	self.viewImage = function(object) {
    	self.view_image = {};
		
		if(object.image) {
			self.view_image.image_path = "/uploads/temp/icon/" + object.image;
		} else if(object.icon_image) {
			self.view_image.image_path = object.icon_image;
		}

		self.view_image.teaching_module = (object.name) ? object.name : Constants.MODULE;
		self.view_image.show = Constants.TRUE;

		$("#view_image_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
    }

    self.removeImage = function(object) {
    	self.view_image = {};

    	object.image = Constants.EMPTY_STR;
    	object.image_path = Constants.EMPTY_STR;
    	object.uploaded = Constants.FALSE;
    }
}