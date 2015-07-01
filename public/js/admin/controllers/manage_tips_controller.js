angular.module('futureed.controllers')
	.controller('ManageTipsController', ManageTipsController);

ManageTipsController.$inject = ['$scope', 'ManageTipsService', 'TableService', 'SearchService'];

function ManageTipsController($scope, ManageTipsService, TableService, SearchService) {
	var self = this;
	
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active) {
		self.errors = Constants.FALSE;

		self.active_list = Constants.FALSE;

		switch(active) {

			case Constants.ACTIVE_LIST : 
			default:
				self.active_list = Constants.TRUE;
				break;
		}
	}
}