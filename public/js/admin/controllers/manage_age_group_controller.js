angular.module('futureed.controllers')
	.controller('ManageAgeGroupController', ManageAgeGroupController);

ManageAgeGroupController.$inject = ['$scope', '$timeout', 'ManageAgeGroupService', 'apiService', 'TableService', 'SearchService'];

function ManageAgeGroupController($scope, $timeout, ManageAgeGroupService, apiService, TableService, SearchService) {
	var self = this;

	self.details = {};
	self.delete = {};

	TableService(self);
	self.tableDefaults();

	self.setModule = function(data) {
        self.module = data;
        self.module.id = data.id;
    }

	self.setActive = function(active, id, flag) {
		self.fields = [];
		self.errors = Constants.FALSE;
		self.create = {};
		self.area_field = Constants.FALSE;

		self.active_list = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.edit = Constants.FALSE;

		if(flag != 1) {
			self.success = Constants.FALSE;
		}

		switch (active) {
			case Constants.ACTIVE_EDIT:
				self.active_edit = Constants.TRUE;
				self.getAgeGroupDetail(id);
				self.edit = Constants.TRUE;
				self.success = Constants.FALSE;
				break;

			case Constants.ACTIVE_ADD : 
				self.active_add = Constants.TRUE;
				break;

			default:
				self.active_list = Constants.TRUE;
				self.ageModuleList();
				break;
		}
	}

	self.ageModuleList = function() {
		self.errors = Constants.FALSE;
		self.records = {};
		$scope.ui_block();
		ManageAgeGroupService.ageModuleList(self.module.id, self.table).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.age_records = response.data.records;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getAge = function() {
		$scope.ui_block();

		ManageAgeGroupService.getAge().success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.ages = {};
					self.ages = response.data;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.addAgeGroup = function() {
		self.errors = Constants.FALSE;
		self.create.success = Constants.FALSE;
		self.create.module_id = $scope.module_id;

		$scope.ui_block();
		ManageAgeGroupService.addAgeGroup(self.create).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.create = {};
					self.create.success = Constants.TRUE;
				}
			}
		$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getAgeGroupDetail = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageAgeGroupService.getAgeGroupDetail(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.details = response.data;
				}
			}
		$scope.ui_unblock();
		}).error(function(response) {
			self.errors = internalError();
			$scope.ui_unblock();
		});
	}

	self.saveAgeGroup = function() {
		self.errors = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageAgeGroupService.saveAgeGroup(self.details).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.success = ManageModuleConstants.SUCCESS_EDIT_AGE_GROUP;
					$timeout(function() {
					    angular.element('#age-list-btn').trigger('click');
					  }, 1);
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

		$("#delete_age_group_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.deleteAgeGroup = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageAgeGroupService.deleteAgeGroup(self.delete.id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = ManageModuleConstants.SUCCESS_DELETE_AGE_GROUP;
					$timeout(function() {
					    angular.element('#age-list-btn').trigger('click');
					  }, 1);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}
}