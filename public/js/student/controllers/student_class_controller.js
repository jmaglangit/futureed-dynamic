angular.module('futureed.controllers')
	.controller('StudentClassController', StudentClassController);

StudentClassController.$inject = ['$scope', 'StudentClassService'];

function StudentClassController($scope, StudentClassService) {

	var self = this;

	self.tips = {};
	self.student_id = $scope.user.id;

	self.click = function() {
		self.add_tips = Constants.FALSE;
		self.bool_change_class = !self.bool_change_class;
		self.send_behind = !self.send_behind;
	}

	self.addTips = function() {
		self.add_tip_class = !self.add_tip_class;
		self.add_tips = Constants.TRUE;
		self.tips.success = Constants.FALSE;
		self.tips = {};
	}

	self.backTips = function() {
		self.tips = {};
		self.add_tips = Constants.FALSE;
	}

	self.submitTips = function() {
		self.tips.errors = Constants.FALSE;
		self.tips.success = Constants.FALSE;
		self.tips.student_id = self.student_id;
		$scope.ui_block();
		StudentClassService.submitTips(self.tips).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.tips.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.tips.success = Constants.TRUE;
					self.tips.errors = Constants.FALSE;
					self.add_tips = Constants.FALSE;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		})
	}
}