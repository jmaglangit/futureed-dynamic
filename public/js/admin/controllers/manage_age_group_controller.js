angular.module('futureed.controllers')
	.controller('ManageAgeGroupController', ManageAgeGroupController);

ManageAgeGroupController.$inject = ['$scope', 'ManageAgeGroupService', 'apiService', 'TableService', 'SearchService'];

function ManageAgeGroupController($scope, ManageAgeGroupService, apiService, TableService, SearchService) {
	var self = this;

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
				self.list();
				break;
		}
	}

	
}