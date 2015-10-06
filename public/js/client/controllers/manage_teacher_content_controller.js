angular.module('futureed.controllers')
	.controller('ManageTeacherContentController', ManageTeacherContentController);

ManageTeacherContentController.$inject = ['$scope', '$window', 'ManageTeacherContentService', 'TableService'];

function ManageTeacherContentController($scope, $window, ManageTeacherContentService, TableService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	self.setModule = function(id) {
		if(id) {
			self.current_module = id;
		}

		self.setActive();
	}

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_list = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_LIST :
				self.success = Constants.FALSE;

			default :
				self.active_list = Constants.TRUE;
				self.list();
				break;
		}
	}

	self.list = function() {
		if(self.active_list) {
			self.listContent();
		}
	}

	self.listContent = function() {
		self.errors = Constants.FALSE;
		self.table.size = 1;

		$scope.ui_block();
		ManageTeacherContentService.listContent(self.current_module, self.table).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else if(response.data) {
						self.content = response.data.records[0];
						self.updatePageCount(response.data);
					}
				}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.selectAllContents = function() {
		ManageTeacherContentService.selectAllContents(self.current_module).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.records;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.getContent = function(id, index) {
		$scope.ui_block();
		ManageTeacherContentService.getContent(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.content = response.data;
					self.table.page = index + 1;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.viewQuestions = function(url) {
		$window.location.href = url + "/" + self.current_module;
	}
}