angular.module('futureed.controllers')
	.controller('AdminClientController', AdminClientController);

AdminClientController.$inject = ['$scope', 'adminClientService'];

function AdminClientController($scope, adminClientService) {
	var self = this;

	self.create = {};
	self.role = {};
	self.setManageClientActive = setManageClientActive;
	self.setClientRole = setClientRole;
	self.createNewClient = createNewClient;

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
		self.role = {};

		if(angular.equals(self.create.client_role, Constants.PRINCIPAL)) {
			self.role.principal = Constants.TRUE;
		} else if(angular.equals(self.create.client_role, Constants.PARENT)) {
			self.role.parent = Constants.TRUE;
		} else if(angular.equals(self.create.client_role, Constants.TEACHER)) {
			self.role.teacher = Constants.TRUE;
		}
	}

	function createNewClient() {
		self.errors = Constants.FALSE;
		self.base_url = $("#base_url_form input[name='base_url']").val();
		self.create.callback_uri = self.base_url + Constants.URL_REGISTRATION(angular.lowercase(self.create.client_role));

		$("input, select").removeClass("required-field");
		$scope.ui_block();
		adminClientService.createNewClient(self.create).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						$("input[name='" + value.field + "'], select[name='" + value.field + "']").addClass("required-field");
					});
				} else if(response.data) {
					console.log(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}