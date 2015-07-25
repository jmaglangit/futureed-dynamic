angular.module('futureed.controllers')
	.controller('ManageTeacherContentController', ManageTeacherContentController);

ManageTeacherContentController.$inject = ['$scope', 'ManageTeacherContentService', 'apiService'];

function ManageTeacherContentController($scope, ManageTeacherContentService, apiService) {
	var self = this;

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.fields = [];

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch(active) {
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

		ManageTeacherContentService.listContent($scope.user.module_id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					} else if(response.data) {
						self.records = response.data.records;
						self.total = response.data.total-1;

						angular.forEach(self.records,function(value,key){
							value.key = key;
						});
						self.showContent(0);
					}
				}
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
	
	self.showContent = function(key, flag) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		var seq = key;

		if(flag == Constants.NEXT){
			seq += 1;
		}else if(flag == Constants.BACK){
			seq -= 1;
		}

		self.details = {};

		self.details = self.records[seq];
		if(self.details.media_type_id == Constants.IMAGE) {
			self.details.image_path = '/uploads/content/' + self.details.id + '/' + self.details.content_url;
			$('#content-image').append("hi");
		}
		$scope.ui_unblock();
	}
}