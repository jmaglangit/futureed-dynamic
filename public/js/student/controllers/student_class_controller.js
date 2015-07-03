angular.module('futureed.controllers')
	.controller('StudentClassController', StudentClassController);

StudentClassController.$inject = ['$scope', 'StudentClassService'];

function StudentClassController($scope, StudentClassService) {

	var self = this;

	self.tips = {};
	self.help = {};
	self.student_id = $scope.user.id;

	self.click = function() {
		self.add_tips = Constants.FALSE;
		self.bool_change_class = !self.bool_change_class;
		self.send_behind = !self.send_behind;
		$('#div-out').animate({left:300},600);
	}

	self.addTips = function() {
		self.add_tip_class = !self.add_tip_class;
		self.add_tips = Constants.TRUE;
		self.tips.success = Constants.FALSE;
		self.alert = Constants.FALSE;
		self.tips = {};
	}

	self.backTips = function() {
		self.tips = {};
		self.add_tips = Constants.FALSE;
		self.add_tip_class = Constants.FALSE;
	}

	self.submitTips = function() {
		self.tips.errors = Constants.FALSE;
		self.tips.success = Constants.FALSE;
		self.tips.student_id = self.student_id;
		$scope.ui_block();
		StudentClassService.submitTips(self.tips).success(function(response){
		self.alert = Constants.TRUE;
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

	self.addHelp = function() {
		self.add_help = Constants.TRUE;
		self.help.success = Constants.FALSE;
		self.help.errors = Constants.FALSE;
		self.alert = Constants.FALSE;
	}

	self.submitHelp = function() {
		self.help.errors = Constants.FALSE;
		self.help.success = Constants.FALSE;
		self.help.student_id = self.student_id;
		self.help.class_id = parseInt(1);
		self.help.module_id = parseInt(1);
		self.help.subject_id = parseInt(1);
		self.help.subject_area_id = parseInt(1);
		self.help.link_type = 'General';
		self.help.link_id = parseInt(1);
		self.help.request_status = 'Pending';
		self.help.question_status = 'Open';

		$scope.ui_block();
		StudentClassService.submitTips(self.help).success(function(response){
		self.alert = Constants.TRUE;
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.help.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.help.success = Constants.TRUE;
					self.help.errors = Constants.FALSE;
					self.add_help = Constants.FALSE;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.backHelp = function() {
		self.help = {};
		self.add_help = Constants.FALSE;
		self.add_help_class = Constants.FALSE;
	}
}