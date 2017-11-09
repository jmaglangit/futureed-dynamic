angular.module('futureed.controllers')
	.controller('ManageTeacherQuestionController', ManageTeacherQuestionController);

ManageTeacherQuestionController.$inject = ['$scope', '$window', 'ManageTeacherQuestionService', 'TableService', 'SearchService'];

function ManageTeacherQuestionController($scope, $window, ManageTeacherQuestionService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setModule = function(id) {
		if(id) {
			self.current_module = id;
		}

		self.setActive()
	}

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_list = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_LIST :
				self.success = Constants.FALSE;

			default :
				self.active_list = Constants.TRUE;
				self.viewQuestion();
				break;
		}
	}

	self.list = function() {
		self.viewQuestion();
	}

	self.searchFnc = function(event) {
		event = getEvent(event);
		event.preventDefault();

		self.tableDefaults();
		self.viewQuestion();
	}

	self.clearFnc = function(event) {
		event = getEvent(event);
		event.preventDefault();

		self.tableDefaults();
		self.searchDefaults();
		self.viewQuestion();
	}

	self.viewQuestion = function() {
		self.errors = Constants.FALSE;
		self.search.module_id = self.current_module;

		self.table.size = 1;

		$scope.ui_block();
		ManageTeacherQuestionService.viewQuestion(self.search, self.table).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.record = response.data.records[0];
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.viewContents = function(url) {
		$window.location.href = url + "/" + self.current_module;
	}
}