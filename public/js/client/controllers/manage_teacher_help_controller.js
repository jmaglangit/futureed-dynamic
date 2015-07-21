angular.module('futureed.controllers')
	.controller('ManageTeacherHelpController', ManageTeacherHelpController);

ManageTeacherHelpController.$inject = ['$scope', 'ManageTeacherHelpService', 'TableService', 'SearchService'];

function ManageTeacherHelpController($scope, ManageTeacherHelpService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

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
				
				self.searchDefaults();
				self.tableDefaults();
				self.list();
				break;
		}
	}

	self.searchFnc = function(event) {
		self.success = Constants.FALSE;

		self.tableDefaults();
		self.list();

		event = getEvent(event);
		event.preventDefault();
	}

	self.clearFnc = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.searchDefaults();
		self.tableDefaults();

		self.list();
	}

	self.list = function() {
		if(self.active_list) {
			self.listHelp();
		}
	}

	self.listHelp = function() {
		self.errors = Constants.FALSE;
		self.records = [];
		self.table.loading = Constants.TRUE;
		self.search.class_id = $scope.classid;

		$scope.ui_block();
		ManageTeacherHelpService.listHelp(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.records = response.data.records;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.detail = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageTeacherHelpService.detail(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.record = {};

					var record = response.data;
					
					self.record.link_type = record.link_type;
					self.record.request_status = record.request_status;
					self.record.status = record.status;
					self.record.id = record.id;
					self.record.subject = record.subject;
					self.record.subject_area = record.subject_area;
					self.record.module = record.module;
					self.record.created_at = record.created_at;
					self.record.title = record.title;
					self.record.content = record.content;
					self.record.created_by = record.student.first_name + ' ' + record.student.last_name;

				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.update = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageTeacherHelpService.update(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = TeacherConstant.SUCCESS_EDIT_HELP;
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateStatus = function(id, status) {
		self.success = Constants.FALSE;
		self.errors = Constants.FALSE;
		var tip_status = (status) ? Constants.ACCEPTED : Constants.REJECTED;

		$scope.ui_block();

		ManageTeacherHelpService.updateStatus(id, tip_status).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = (status) ? TeacherConstant.APPROVE_HELP : TeacherConstant.REJECT_HELP;
					self.setActive(Constants.ACTIVE_VIEW, id);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}
}