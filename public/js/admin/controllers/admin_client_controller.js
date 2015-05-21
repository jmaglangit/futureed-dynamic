angular.module('futureed.controllers')
	.controller('AdminClientController', AdminClientController);

AdminClientController.$inject = ['$scope'];

function AdminClientController($scope) {
	var self = this;

	self.create = {};
	self.setManageClientActive = setManageClientActive;
	self.createNewClient = createNewClient;

	$scope.$watch(self.create.role, function(asd) {
		console.log(asd);
	});

	function setManageClientActive(active) {
		self.errors = Constants.FALSE;

		self.active_add_client = Constants.FALSE;
		self.active_client_list = Constants.FALSE;


		switch(active) {
			
			case "add_client" 	:
				self.active_add_client = Constants.TRUE;
				break;

			case "client_list"	:
			default:
				self.active_client_list = Constants.TRUE;
				break
		}

		$('input, select').removeClass('required-field');
	    $("html, body").animate({ scrollTop: 0 }, "slow");
	}

	function setClientRole() {
		// self.client.role = 
	}

	function createNewClient() {
		self.errors = Constants.FALSE;

		console.log(self.create);
	}
}