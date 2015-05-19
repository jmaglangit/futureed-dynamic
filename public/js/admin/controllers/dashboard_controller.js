angular.module('futureed')
	.controller('AdminDashboardController', AdminDashboardController);

AdminDashboardController.$inject = ['$scope'];

function AdminDashboardController($scope){
	var self = this;
	this.change = {};

	this.changeField = changeField;
	this.setActiveAdmin = setActiveAdmin;	

	$scope.role_select = Constants.TRUE;

	/*Field Changes on role select*/
	function changeField(field){

		switch(field){

			case Constants.PRINCIPAL:
				self.principal = Constants.TRUE;
				self.teacher = Constants.FALSE;
				self.parent = Constants.FALSE;
				break;

			case Constants.TEACHER:
				self.teacher = Constants.TRUE;
				self.principal = Constants.FALSE;
				self.parent = Constants.FALSE;
				self.role_select = Constants.FALSE;
				break;

			case Constants.PARENT:
				self.parent = Constants.TRUE;
				self.principal = Constants.FALSE;
				self.teacher = Constants.FALSE;
				self.role_select = Constants.FALSE;

		}
	}
	/*Set Active and Change Fields*/
	function setActiveAdmin(active){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		switch(active) {			

			case Constants.STUDENT:
				self.active_student = Constants.TRUE;
				self.active_client = Constants.FALSE;
				break;

			case Constants.ADD_CLIENT:
				self.active_client = Constants.TRUE;
				self.active_student = Constants.FALSE;
				self.active_add_client = Constants.TRUE;
				self.add_client = Constants.TRUE;
				self.client_list = Constants.FALSE;
				break;

			case Constants.CLIENT:
			default:
				self.active_client = Constants.TRUE;
				self.active_student = Constants.FALSE;
				self.client_list = Constants.TRUE;
				self.add_client = Constants.FALSE;
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

}