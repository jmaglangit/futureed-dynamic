angular.module('futureed.controllers')
	.controller('ManageAgeGroupController', ManageAgeGroupController);

ManageAgeGroupController.$inject = ['$scope', 'ManageAgeGroupService', 'apiService', 'TableService', 'SearchService'];

function ManageAgeGroupController($scope, ManageAgeGroupService, apiService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	self.setActive = function(active, id, flag) {
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
				self.getModuleDetail(id);
				self.edit = Constants.TRUE;
				self.success = Constants.FALSE;
				break;

			case Constants.ACTIVE_ADD : 
				self.active_add = Constants.TRUE;
				break;

			default:
				self.active_list = Constants.TRUE;
				break;
		}
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
		self.fields = [];
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
}