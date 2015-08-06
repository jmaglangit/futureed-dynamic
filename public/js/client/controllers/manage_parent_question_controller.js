angular.module('futureed.controllers')
	.controller('ManageParentQuestionController', ManageParentQuestionController);

ManageParentQuestionController.$inject = ['$scope', 'ManageParentQuestionService', 'apiService'];

function ManageParentQuestionController($scope, ManageParentQuestionService, apiService) {
	var self = this;

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.fields = [];

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_LIST :
				self.success = Constants.FALSE;

			default :
				self.active_list = Constants.TRUE;

				break;
		}
	}

	self.view = function() {
		if(self.active_list) {
			self.viewQuestion();
		}
	}

	self.viewQuestion = function(seq, flag) {
		self.errors = Constants.FALSE;
		self.filter = {};
		self.filter.id = $scope.user.module_id;
		self.filter.limit = 1;
		self.filter.offset = (seq != null) ? seq:0;
		if(flag == Constants.NEXT){
			self.filter.offset + 1;
		}else if(flag == Constants.BACK){
				self.filter.offset = seq - 2;
		}

		$scope.ui_block();
		
		ManageParentQuestionService.viewQuestion(self.filter, self.q_difficulty).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else if(response.data) {
						self.details = response.data.records[0];
						self.question_total = response.data.total;
					}
				}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.setDifficulty = function() {
		self.hide_difficulty = Constants.TRUE;
		self.q_difficulty = self.details.difficulty_filter
		self.view();
	}
}