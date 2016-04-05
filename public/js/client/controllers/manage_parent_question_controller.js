angular.module('futureed.controllers')
	.controller('ManageParentQuestionController', ManageParentQuestionController);

ManageParentQuestionController.$inject = ['$scope', 'ManageParentQuestionService', 'apiService'];

function ManageParentQuestionController($scope, ManageParentQuestionService, apiService) {
	var self = this;

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.purchase = Constants.FALSE;
		self.fields = [];

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.offset = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_LIST :
				self.success = Constants.FALSE;

			default :
				self.active_list = Constants.TRUE;
				self.viewQuestion();

				break;
		}
	}

	self.view = function() {
		if(self.active_list) {
			self.viewQuestion();
		}
	}

	self.viewQuestion = function(flag) {
		self.errors = Constants.FALSE;
		self.filter = {};
		self.filter.id = $scope.user.module_id;
		self.filter.limit = 1;
		self.filter.offset = (self.offset) ? self.offset :  Constants.TRUE;

		if(flag == Constants.NEXT){
			self.offset += 1;
		}else if(flag == Constants.BACK){
			self.offset -= 1;
		}

		self.filter.offset = self.offset;

		if (self.filter.offset >= Constants.TRIAL_QUESTIONS) {
			self.purchase = Constants.TRUE;
			self.active_list = Constants.FALSE;
		} else {

			$scope.ui_block();

			ManageParentQuestionService.viewQuestion(self.filter, self.q_difficulty).success(function (response) {
				if (angular.equals(response.status, Constants.STATUS_OK)) {
					if (response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else if (response.data) {
						self.details = response.data.records[0];
						self.question_total = response.data.total;
					}
				}
				$scope.ui_unblock();
			}).error(function (response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		}
	}

	self.setDifficulty = function() {
		self.hide_difficulty = Constants.TRUE;
		self.q_difficulty = self.details.difficulty_filter
		self.view();
	}
}