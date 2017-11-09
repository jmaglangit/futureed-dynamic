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
		self.active_report = Constants.FALSE;
		self.classroom_id = Constants.FALSE;
		self.exort = Constants.FALSE;

		switch(active) {
			case Constants.DASHBOARD :
				self.getClassList();
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

	self.getClassList = function(){
		ManageTeacherContentService.getClassList($scope.user.id).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.class_list = response.data.record;
					self.getDashboardReport(self.class_list[0].id);
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	self.getDashboardReport = function (classroom_id) {
		self.additional_information = {};
		self.column_header = {};
		self.record = {};
		self.classroom_id = (self.classroom_id) ? self.classroom_id : classroom_id;
		self.teacher_report_export = Constants.FALSE;

		$scope.ui_block();
		ManageTeacherContentService.getClassReport(self.classroom_id).success(function(response) {
			if(response.status == Constants.STATUS_OK) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.additional_information = response.data.additional_information;
					self.column_header = response.data.column_header[0];
					self.record = response.data.rows[0];
					self.active_report = Constants.TRUE;
					self.teacher_report_export = "/api/report/classroom/" + self.classroom_id;
				}
			}
		$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.evaluateTooltip = function (string, max_length) {
		return string.length > max_length ? string : null;
	}

    self.shortenString = function (string, max_length) {
        if (string.length <= max_length) {
            return string;
        } else {
            return (string.slice(0, max_length - 3) + '...');
        }
    }
}