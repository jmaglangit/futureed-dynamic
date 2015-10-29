angular.module('futureed.controllers')
	.controller('ManageTeacherTipsController', ManageTeacherTipsController);

ManageTeacherTipsController.$inject = ['$scope', 'ManageTeacherTipsService', 'TableService', 'SearchService'];

function ManageTeacherTipsController($scope, ManageTeacherTipsService, TableService, SearchService) {
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
				self.tipDetail(id);
				self.active_view = Constants.TRUE;
				break;

			case Constants.ACTIVE_EDIT :
				self.success = Constants.FALSE;
				self.active_edit = Constants.TRUE;
				self.tipDetail(id);
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
			self.listTips();
		}
	}

	self.listTips = function() {
		self.errors = Constants.FALSE;
		self.records = [];
		self.search.class_id = $scope.classid;
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageTeacherTipsService.list(self.search, self.table).success(function(response) {
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

	self.tipDetail = function(id) {
		self.errors = Constants.FALSE;
		self.record = {};

		$scope.ui_block();
		ManageTeacherTipsService.detail(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var record = response.data;

					self.record.id = record.id;
					self.record.created_at = record.created_at;
					self.record.created_by = record.student.first_name + ' ' + record.student.last_name;
					self.record.link_type = record.link_type;
					
					self.record.title = record.title;
					self.record.content = record.content;
					self.record.status = record.status;

					if(angular.equals(record.link_type, Constants.CONTENT)) {
						self.record.subject = record.subject.name;
						self.record.subject_area = record.subjectarea.name;
						self.record.module = record.module.name;
					}

					self.record.tip_status = record.tip_status;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.update = function(){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.fields = [];

		$scope.ui_block();
		ManageTeacherTipsService.update(self.record).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors, Constants.TRUE);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				}else if(response.data){
					self.success = TeacherConstant.SUCCESS_EDIT_TIP;
					self.setActive(Constants.ACTIVE_VIEW, response.data.id);
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
		self.rate = {};
		self.rate.id = id;
		self.rate.tip_status = tip_status;
		self.rate.rated_by = Constants.TEACHER;
		self.rate.rating = self.rating;

		$scope.ui_block();
		ManageTeacherTipsService.updateStatus(self.rate).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.rate_errors = $scope.errorHandler(response.errors, Constants.TRUE);
				}else if(response.data){
					$("#rate_tip").modal('hide');
					self.success = (status) ? TeacherConstant.APPROVE_TIP : TeacherConstant.REJECT_TIP;
					self.setActive(Constants.ACTIVE_VIEW, id);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.rateTip = function() {
		self.rate_errors = Constants.FALSE;
		self.rate_modal = Constants.TRUE;

		$("#rate_tip").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}
}