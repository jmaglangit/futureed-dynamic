angular.module('futureed.controllers')
	.controller('ManageHelpRequestController', ManageHelpRequestController);

ManageHelpRequestController.$inject = ['$scope', 'ManageHelpRequestService', 'TableService', 'SearchService'];

function ManageHelpRequestController($scope, ManageHelpRequestService, TableService, SearchService) {
	var self = this;
	
	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	// TODO: delete if API is OK. Dummy data just to show view / edit icons in list
	self.records = [{
		asd : 'asd'
	}];

	self.setActive = function(active) {
		self.errors = Constants.FALSE;

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch(active) {

			case Constants.ACTIVE_VIEW :
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT :
				self.active_edit = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST : 
			default:
				self.active_list = Constants.TRUE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.updateHelpRequest = function() {
		self.setActive(Constants.ACTIVE_VIEW);
	}

	self.searchFnc = function() {

	}

	self.clearFnc = function() {
		
	}
}