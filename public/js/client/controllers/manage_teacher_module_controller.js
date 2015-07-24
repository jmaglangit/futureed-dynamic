angular.module('futureed.controllers')
	.controller('ManageTeacherModuleController', ManageTeacherModuleController);

ManageTeacherModuleController.$inject = ['$scope', 'ManageTeacherModuleService', 'TableService', 'SearchService', 'apiService'];

function ManageTeacherModuleController($scope, ManageTeacherModuleService, TableService, SearchService, apiService) {
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
				self.detail(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT :
				self.success = Constants.FALSE;
				self.active_edit = Constants.TRUE;
				self.detail(id);
				break;

			case Constants.ACTIVE_LIST :
				self.success = Constants.FALSE;

			default :
				self.active_list = Constants.TRUE;
				
				self.searchDefaults();
				self.tableDefaults();
				self.list();
				break;
		}
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
			self.listModule();
		}
	}

	self.listModule = function() {
		self.errors = Constants.FALSE;
		self.records = [];
		self.table.loading = Constants.TRUE;
		self.search.class_id = $scope.classid;

		$scope.ui_block();
		ManageTeacherModuleService.listModule(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				self.getGradeLevel($scope.user.country_id);
				self.getSubject();
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

	self.getGradeLevel = function(country_id) {
		self.grades = Constants.FALSE;

		apiService.getGradeLevel(country_id).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.grades = response.data.records;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.getSubject = function() {
		self.subjects = Constants.FALSE;

		ManageTeacherModuleService.getSubject().success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.subjects = response.data.records;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}
	self.detail = function(id) {
		$scope.ui_block();
		ManageTeacherModuleService.detail(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.record = {};

					self.record = response.data;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}
}