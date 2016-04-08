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
		self.has_subscription = Constants.FALSE;

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
		self.filter.user_id = $scope.user.id;

		if (self.filter.offset >= Constants.TRIAL_QUESTIONS
			&& self.has_subscription == Constants.FALSE) {
			self.purchase = Constants.TRUE;
			self.active_list = Constants.FALSE;
		} else {

			ManageParentQuestionService.viewQuestion(self.filter).success(function (response) {
				if (angular.equals(response.status, Constants.STATUS_OK)) {
					if (response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else if (response.data) {
						self.details = response.data.questions.records[0];
						self.question_total = response.data.questions.total;
						self.has_subscription = response.data.client_subscription;
					}
				}
			}).error(function (response) {
				self.errors = $scope.internalError();
			});
		}
	}

	self.setDifficulty = function() {
		self.hide_difficulty = Constants.TRUE;
		self.q_difficulty = self.details.difficulty_filter
		self.view();
	}
}