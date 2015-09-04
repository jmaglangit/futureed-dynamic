angular.module('futureed.controllers')
	.controller('ManageModuleController', ManageModuleController);

ManageModuleController.$inject = ['$scope', 'manageModuleService', 'TableService', 'SearchService', 'Upload'];

function ManageModuleController($scope, manageModuleService, TableService, SearchService, Upload) {
	var self = this;

	self.details = {};
	self.delete = {};

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, id, flag) {
		self.errors = Constants.FALSE;
		self.create = {};
		self.area_field = Constants.FALSE;

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.edit = Constants.FALSE;

		if(flag != 1) {
			self.success = Constants.FALSE;
		}

		switch (active) {
			case Constants.ACTIVE_EDIT:
				self.active_edit = Constants.TRUE;
				self.getModuleDetail(id);
				self.edit = Constants.TRUE;
				self.success = Constants.FALSE;
				break;

			case Constants.ACTIVE_VIEW :
				self.active_view = Constants.TRUE;
				self.detail_hidden = Constants.FALSE;
				self.content_hidden = Constants.TRUE;
				self.getModuleDetail(id);
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
		var detail_shown = $('#module_detail').hasClass('in');

		if(detail_shown) {
			self.detail_hidden = Constants.TRUE;
		} else {
			self.detail_hidden = Constants.FALSE;
			self.content_hidden = Constants.TRUE;
		}
	}

	self.toggleContent = function() {
		var content_shown = $('#module_tabs').hasClass('in');
		
		if(content_shown) {
			self.content_hidden = Constants.TRUE;
		} else {
			self.content_hidden = Constants.FALSE;
			self.detail_hidden = Constants.TRUE;
		}
	}

	self.setActiveContent = function(view) {
		self.details.current_view = view;
	}

	self.searchFnc = function(event) {
		self.errors = Constants.FALSE;
		self.tableDefaults();
		self.list();
		
		event = getEvent(event);
		event.preventDefault();
	}

	self.clearFnc = function() {
		self.errors = Constants.FALSE;

		self.searchDefaults();
		self.list();
	}

	self.list = function() {
		self.errors = Constants.FALSE;
		self.records = {};
		self.table.loading = Constants.TRUE;
		$scope.ui_block();

		manageModuleService.list(self.search, self.table).success(function(response){
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

	self.addNewModule = function(){
		self.errors = Constants.FALSE;
		self.create.success = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		manageModuleService.addNewModule(self.create).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.create = {};
					self.validation = {};
					self.create.success = Constants.TRUE;
	    			$("html, body").animate({ scrollTop: 0 }, "slow");
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

		manageModuleService.getSubject().success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.subjects = {};
					self.subjects = response.data.records;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.setSubject = function(method) {

		switch (method){
			case 'create' :
				self.area_field = (self.create.subject_id !='') ? Constants.TRUE:Constants.FALSE;
				break;
			case 'edit' :
				self.area_field = (self.details.subject_id !='') ? Constants.TRUE:Constants.FALSE;
				break;
		}
	}

	self.searchArea = function(method) {
		self.method = method;
		self.validation = {};
		self.validation.s_loading = Constants.TRUE;

		var area = '';
		var subject_id = '';

		switch(method){

			case 'edit':
				area = self.details.area;
				subject_id = self.details.subject.id;
				break;

			case 'create':
			default:
				area = self.create.area;
				subject_id = self.create.subject_id;
				break;
		}

		manageModuleService.searchArea(subject_id, area).success(function(response){
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
						self.areas = {};
						self.areas = response.data.records;
					}
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	self.selectArea = function(area) {
		var method = self.method;

		switch(method){
			case 'edit':
				self.details.subject_area_id = area.id;
				self.details.area = area.name;
				break;

			case 'create':
			default:
				self.create.subject_area_id = area.id;
				self.create.area = area.name;
				break;
		}

		self.areas = Constants.FALSE;
	}

	self.getModuleDetail = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		manageModuleService.getModuleDetail(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.details = response.data;
					self.details.area = (self.details.subjectarea) ? self.details.subjectarea.name : Constants.EMPTY_STR;
					$scope.module_id = self.details.id;
					$scope.module_name = self.details.name;
					self.age_records = {};
				}
			}
		$scope.ui_unblock();
		}).error(function(response) {
			self.errors = internalError();
			$scope.ui_unblock();
		});
	}

	self.saveModule = function(){
		self.errors = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		manageModuleService.saveModule(self.details).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.validation = {};
					self.success = Constants.TRUE;
					self.setActive('view', self.details.id, 1);
	    			$("html, body").animate({ scrollTop: 0 }, "slow");
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
		self.delete.id = id;
		self.delete.confirm = Constants.TRUE;

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
		manageModuleService.deleteModule(self.delete.id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = ManageModuleConstants.SUCCESS_DELETE_MOD;
					self.setActive('list', '', 1);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.upload = function(file, object) {
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