angular.module('futureed.controllers')
	.controller('StudentModuleController', StudentModuleController);

StudentModuleController.$inject = ['$scope', 'apiService', 'StudentModuleService'];

function StudentModuleController($scope, apiService, StudentModuleService) {
	var self = this;

	self.add = {};

	self.toggleBtn = function() {
		self.toggle_bottom = !self.toggle_bottom;
	}

	self.toggleBtnHelp = function() {
		self.toggle_help_bottom = !self.toggle_help_bottom;
	}

	self.giveTip = function() {
		self.toggle_bottom = !self.toggle_bottom;
	}

	self.askHelp = function() {
		self.toggle_help_bottom = !self.toggle_help_bottom;
	}

	self.addHelp = function() {
		// temprary declare ID's
		self.add.module_id = parseInt(1);
		self.add.subject_id = parseInt(1);
		self.add.link_id = parseInt(1);
		self.add.link_type = 'Question';
		self.add.class_id = $scope.user.class.id;
		self.add.student_id = $scope.user.id;

		$scope.ui_block();
		StudentModuleService.addHelp(self.add).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.success = Constants.FALSE;
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = Constants.TRUE;
					self.errors = Constants.FALSE;
					self.add = {};
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}
}