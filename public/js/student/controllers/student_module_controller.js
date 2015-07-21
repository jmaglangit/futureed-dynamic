angular.module('futureed.controllers')
	.controller('StudentModuleController', StudentModuleController);

StudentModuleController.$inject = ['$scope', 'apiService', 'StudentModuleService'];

function StudentModuleController($scope, apiService, StudentModuleService) {
	var self = this;

	self.add = {};

	self.toggleBtn = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.toggle_bottom = !self.toggle_bottom;
	}

	self.toggleBtnHelp = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.toggle_help_bottom = !self.toggle_help_bottom;
		self.setHelpActive();
	}

	self.giveTip = function() {
		self.toggle_bottom = !self.toggle_bottom;
	}

	self.askHelp = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.toggle_help_bottom = !self.toggle_help_bottom;
		self.setHelpActive('add');
	}

	self.setHelpActive = function(active, id) {
		self.active_help_list = Constants.FALSE;
		self.active_help_add = Constants.FALSE;
		self.active_help_view = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_VIEW:
				self.active_help_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_ADD:
				self.active_help_add = Constants.TRUE;
				break;

			default:
				self.active_help_list = Constants.TRUE;
				break;
		}
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

	self.setCurrentActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_current_list = Constants.FALSE;
		self.active_current_view = Constants.FALSE;

		switch(active){
			case Constants.ACTIVE_VIEW:
				self.active_current_view = Constants.TRUE;
				break;
			default:
				self.active_current_list = Constants.TRUE;
				self.currentList();
				break;
		}

	}

	self.currentList = function(){
		// setting temporary request id
		self.request = {};
		self.request.student_id = $scope.user.id;
		self.request.module_id = 1;
		self.request.link_type = 'Question';
		self.request.help_request_type = 'Others';
		self.request.question_status = 'Open'
		self.request.link_id = 1;

		$scope.ui_block();
		StudentModuleService.currentList(self.request).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.records = {};
					self.records = response.data.records;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}
}