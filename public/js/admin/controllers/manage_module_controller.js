angular.module('futureed.controllers')
	.controller('ManageModuleController', ManageModuleController);

ManageModuleController.$inject = ['$scope', 'manageModuleService', 'apiService', 'TableService', 'SearchService'];

function ManageModuleController($scope, manageModuleService, apiService, TableService, SearchService) {
	var self = this;

	self.create = {};
	self.area_field = Constants.FALSE;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_list = Constants.FALSE;

		switch (active) {
			case Constants.ACTIVE_ADD : 
				self.active_add = Constants.TRUE;
				self.active_list = Constants.FALSE;
				break;

			default:
				self.active_list = Constants.TRUE;
				self.active_add = Constants.FALSE;
				self.list();
				break;
		}
		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.searchFnc = function(event) {
		self.errors = Constants.FALSE;
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
		self.success = Constants.FALSE;
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

	self.setSubject = function() {
		self.area_field = (self.create.subject_id !='') ? Constants.TRUE:Constants.FALSE;
	}

	self.searchArea = function(method) {
		self.method = method;
		self.validation = {};
		self.validation.s_loading = Constants.TRUE;

		var area = '';

		switch(method){

			case 'edit':
				area = self.details.area;
				break;

			case 'create':
			default:
				area = self.create.area;
				break;
		}

		manageModuleService.searchArea(self.create.subject_id, area).success(function(response){
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
}