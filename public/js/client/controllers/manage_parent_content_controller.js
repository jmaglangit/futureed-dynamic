angular.module('futureed.controllers')
	.controller('ManageParentContentController', ManageParentContentController);

ManageParentContentController.$inject = ['$scope', 'ManageParentContentService', 'apiService'];

function ManageParentContentController($scope, ManageParentContentService, apiService) {
	var self = this;

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.fields = [];

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;
		self.active_report = Constants.FALSE;

		switch(active) {
			case Constants.DASHBOARD:
				self.listStudents();
				break;

			case Constants.ACTIVE_VIEW :
				self.detail(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT :
				self.success = Constants.FALSE;
				self.active_edit = Constants.TRUE;
				self.detail(id);
				break;

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

		$scope.ui_block();

		ManageParentContentService.listContent($scope.user.module_id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else if(response.data) {
						self.records = response.data.records;
						self.total = response.data.total-1;

						if(response.data.total == Constants.FALSE){
							self.no_content = Constants.TRUE;
						}else{
							self.navigate(0);
						}
					}
				}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
	
	self.navigate = function(key, flag) {
		self.errors = Constants.FALSE;
		$scope.ui_block();
		var seq = key;

		if(flag == Constants.NEXT){
			seq += 1;
		}else if(flag == Constants.BACK){
			seq -= 1;
		}

		self.detail = self.records[seq];
		self.getContent(self.detail.id, key);
		self.detail.key = seq;
		
	}

	self.getContent = function(id, key) {
		self.detail.key = key;
		$scope.ui_block();
		ManageParentContentService.getContent(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else if(response.data) {
						self.content = response.data;
					}
				}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.listStudents = function() {
		console.log($scope.user);
		self.student_list = {};

		$scope.ui_block();
		ManageParentContentService.listStudents($scope.user.id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(response.data.total){
						self.active_report = Constants.TRUE;
						self.student_list = response.data.records;
						console.log(response.data.records);
					}
				}
			}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}
}