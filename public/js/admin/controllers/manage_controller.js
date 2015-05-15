angular.module('futureed')
	.controller('ManageController', ManageController);

ManageController.$inject = ['$scope'];

function ManageController($scope){
	var self = this;
	this.change = {};

	this.changeField = changeField;	

	$scope.role_select = Constants.TRUE;
	function changeField(){	

		if($scope.role == Constants.PRINCIPAL){
			$scope.principal = Constants.TRUE;
			$scope.teacher = Constants.FALSE;
			$scope.parent = Constants.FALSE;			
		}
		else if($scope.role == Constants.TEACHER){
			$scope.teacher = Constants.TRUE;
			$scope.principal = Constants.FALSE;
			$scope.parent = Constants.FALSE;
			$scope.role_select = Constants.FALSE;
		}
		else if($scope.role == Constants.PARENT){
			$scope.parent = Constants.TRUE;
			$scope.principal = Constants.FALSE;
			$scope.teacher = Constants.FALSE;
			$scope.role_select = Constants.FALSE;
		}
	}
}