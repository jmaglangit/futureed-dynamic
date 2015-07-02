angular.module('futureed.controllers')
	.controller('ManageTipsController', ManageTipsController);

ManageTipsController.$inject = ['$scope', 'ManageTipsService', 'TableService', 'SearchService'];

function ManageTipsController($scope, ManageTipsService, TableService, SearchService) {
	var self = this;
	
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	// TODO: delete if API is OK. Dummy data just to show view / edit icons in list
	self.records = [{
		asd : 'asd'
	}];

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch(active) {

			case Constants.ACTIVE_VIEW :
				self.tipDetail(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT :
				self.tipDetail(id);
				self.active_edit = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST : 
			default:
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.updateTip = function() {
		self.setActive(Constants.ACTIVE_VIEW);
	}

	self.searchFnc = function() {

	}

	self.clearFnc = function() {
		
	}

	self.tipDetail = function(id) {
		
	}
}