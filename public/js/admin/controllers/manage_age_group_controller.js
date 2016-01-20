angular.module('futureed.controllers')
	.controller('ManageAgeGroupController', ManageAgeGroupController);

ManageAgeGroupController.$inject = ['$scope', 'ManageAgeGroupService', 'TableService'];

function ManageAgeGroupController($scope, ManageAgeGroupService, TableService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	self.setModule = function(data) {
        self.module = data;
    }

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.fields = [];
		self.record = {};
		self.tableDefaults();

		self.active_list = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch (active) {
			case Constants.ACTIVE_EDIT:
				self.active_edit = Constants.TRUE;
				self.details(id);
				break;

			case Constants.ACTIVE_ADD : 
				self.active_add = Constants.TRUE;
				break;

			default:
				self.active_list = Constants.TRUE;
				self.list();
				break;
		}
	}

	self.list = function() {
		self.errors = Constants.FALSE;
		self.records = [];

		$scope.ui_block();
		ManageAgeGroupService.list(self.module.id, self.table).success(function(response){
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

	self.getAges = function() {
		self.ages = [];

		ManageAgeGroupService.getAges().success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data){
					self.ages = response.data;
				}
			}
		}).error(function(response){
			self.errors = $scope.internalError();
		});
	}

	self.add = function() {
		self.errors = Constants.FALSE;
		self.fields = [];
		
		self.record.module_id = self.module.id;

		$scope.ui_block();
		ManageAgeGroupService.add(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_ADD);
					self.success = Constants.MSG_CREATED("Age group");
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.details = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageAgeGroupService.details(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.record = response.data;
				}
			}
		
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.update = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		
		self.fields = [];

		self.record.age_group_id = self.details.age_group_id;
		self.record.points_earned = self.details.points_earned;

		$scope.ui_block();
		ManageAgeGroupService.update(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_EDIT);
					self.success = Constants.MSG_UPDATED("Age group");
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
		ManageAgeGroupService.deleteAgeGroup(self.record.id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_LIST);
					self.success = Constants.MSG_DELETED("Age group");
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}
}