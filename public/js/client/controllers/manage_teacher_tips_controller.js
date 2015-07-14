angular.module('futureed.controllers')
	.controller('ManageTeacherTipsController', ManageTeacherTipsController);

ManageTeacherTipsController.$inject = ['$scope', 'ManageTeacherTipsService', 'TableService', 'SearchService'];

function ManageTeacherTipsController($scope, ManageTeacherTipsService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setTipsActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.fields = [];

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_VIEW :
				self.tipDetail(id);
				self.active_view = Constants.TRUE;
				self.success = Constants.FALSE;
				break;

			case Constants.ACTIVE_EDIT :
				self.success = Constants.FALSE;
				self.tipDetail(id);
				self.active_edit = Constants.TRUE;
				break;

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

	self.searchHelpFnc = function(event) {
		self.help_success = Constants.FALSE;

		self.tableDefaults();
		self.helpList();

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

	self.clearHelpFnc = function() {
		self.help_errors = Constants.FALSE;
		self.help_success = Constants.FALSE;

		self.searchDefaults();
		self.tableDefaults();

		self.helpList();
	}

	self.list = function() {
		if(self.active_list) {
			self.listTips();
		}
	}

	self.listTips = function() {
		self.classid = $scope.classid;
		self.errors = Constants.FALSE;
		self.records = [];
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageTeacherTipsService.list(self.classid, self.search, self.table).success(function(response) {
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
					self.record.tip_status = record.tip_status;
					self.record.title = record.title;
					self.record.content = record.content;
					self.record.status = record.status;
					self.record.subject = record.subject;
					self.record.subjectarea = record.subjectarea;
					self.record.module = record.module;
					self.record.tip_status = record.tip_status;
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.saveEdit = function(){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageTeacherTipsService.saveEdit(self.record).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = Constants.TRUE;
					var id = response.data.id;
					self.setTipsActive('view', id);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateTips = function(id, status) {
		self.success = Constants.FALSE;
		self.errors = Constants.FALSE;
		
		self.u_tip_status = (status == 1) ? Constants.ACCEPTED:Constants.REJECTED;

		$scope.ui_block();

		ManageTeacherTipsService.updateTips(id, self.u_tip_status).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = (status == 1) ? TeacherConstant.APPROVE_TIP:TeacherConstant.REJECT_TIP;
					self.setTipsActive('list');
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.setHelpActive = function(active, id) {
		self.help_errors = Constants.FALSE;
		self.help_fields = [];

		self.help_active_list = Constants.FALSE;
		self.help_active_view = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_VIEW :
				self.helpDetail(id);
				self.help_active_view = Constants.TRUE;
				self.edit = Constants.FALSE;
				break;

			case Constants.ACTIVE_EDIT :
				self.help_active_view = Constants.TRUE;
				self.help_success = Constants.FALSE;
				self.helpDetail(id);
				self.edit = Constants.TRUE;
				break;

			default :
				self.help_active_list = Constants.TRUE;
				
				self.searchDefaults();
				self.tableDefaults();
				self.helpList();
				break;
		}
	}

	self.helpList = function() {
		self.classid = $scope.classid;
		self.errors = Constants.FALSE;
		self.records = [];
		self.table.loading = Constants.TRUE;

		self.search.title = (self.search.help_title) ? self.search.help_title:Constants.EMPTY_STR;
		self.search.status = (self.search.help_status) ? self.search.help_status:Constants.EMPTY_STR;
		self.search.created = (self.search.help_created) ? self.search.help_created:Constants.EMPTY_STR;
		self.search.subject = (self.search.help_subject) ? self.search.help_subject:Constants.EMPTY_STR;
		self.search.area = (self.search.help_area) ? self.search.help_area:Constants.EMPTY_STR;

		$scope.ui_block();
		ManageTeacherTipsService.listHelp(self.classid, self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.help_errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.help_records = response.data.records;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.help_errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.helpDetail = function(id) {
		self.help_errors = Constants.FALSE;

		$scope.ui_block();

		ManageTeacherTipsService.helpDetail(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.help_errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.help_record = {};
					var help_record = response.data;
					self.help_record.link_type = help_record.link_type;
					self.help_record.request_status = help_record.request_status;
					self.help_record.status = help_record.status;
					self.help_record.id = help_record.id;
					self.help_record.subject = help_record.subject;
					self.help_record.subject_area = help_record.subject_area;
					self.help_record.module = help_record.module;
					self.help_record.created_at = help_record.created_at;
					self.help_record.title = help_record.title;
					self.help_record.content = help_record.content;
					self.help_record.created_by = help_record.student.first_name + ' ' + help_record.student.last_name;

				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.help_errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.saveEditHelp = function() {
		self.help_errors = Constants.FALSE;
		self.help_success = Constants.FALSE;
		$scope.ui_block();
		ManageTeacherTipsService.saveEditHelp(self.help_record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.help_errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.help_success = TeacherConstant.SUCCESS_EDIT_HELP;
					self.setHelpActive('view', self.help_record.id);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.help_errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.setHelpAnsActive = function(active, id) {
		self.help_ans_errors = Constants.FALSE;
		self.help_ans_fields = [];

		self.help_ans_active_list = Constants.FALSE;
		self.help_ans_active_view = Constants.FALSE;
		self.help_ans_active_edit = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_VIEW :
				self.helpAnsDetail(id);
				self.help_ans_active_view = Constants.TRUE;
				self.help_ans_edit = Constants.FALSE;
				break;

			case Constants.ACTIVE_EDIT :
				self.help_ans_active_view = Constants.TRUE;
				self.help_ans_success = Constants.FALSE;
				self.helpAnsDetail(id);
				self.help_ans_edit = Constants.TRUE;
				break;

			default :
				self.help_ans_active_list = Constants.TRUE;
				
				self.searchDefaults();
				self.tableDefaults();
				self.helpAnsList();
				break;
		}
	}

	self.updateHelp = function(id, status) {
		self.success = Constants.FALSE;
		self.errors = Constants.FALSE;
		self.u_tip_status = (status == 1) ? Constants.ACCEPTED:Constants.REJECTED;

		$scope.ui_block();

		ManageTeacherTipsService.updateHelp(id, self.u_tip_status).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.help_errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.help_success = (status == 1) ? TeacherConstant.APPROVE_HELP:TeacherConstant.REJECT_HELP;
					self.setHelpActive('list');
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.helpAnsList = function() {
		self.classid = $scope.classid;
		self.help_ans_errors = Constants.FALSE;
		self.help_ans_records = [];
		self.table.loading = Constants.TRUE;

		self.search.title = (self.search.ans_title) ? self.search.ans_title:Constants.EMPTY_STR;
		self.search.status = (self.search.ans_status) ? self.search.ans_status:Constants.EMPTY_STR;
		self.search.created = (self.search.ans_created) ? self.search.ans_status:Constants.EMPTY_STR;
		self.search.subject = (self.search.ans_subject) ? self.search.ans_subject:Constants.EMPTY_STR;
		self.search.area = (self.search.ans_area) ? self.search.ans_area:Constants.EMPTY_STR;

		$scope.ui_block();
		ManageTeacherTipsService.helpAnsList(self.search, self.table).success(function(response) {
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.help_ans_errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.help_ans_records = response.data.records;
					self.updatePageCount(response.data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.help_ans_errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.searchAnsFnc = function(event) {
		self.help_ans_success = Constants.FALSE;

		self.tableDefaults();
		self.helpAnsList();

		event = getEvent(event);
		event.preventDefault();
	}

	self.clearAnsFnc = function() {
		self.help_ans_errors = Constants.FALSE;
		self.help_ans_success = Constants.FALSE;

		self.searchDefaults();
		self.tableDefaults();

		self.helpAnsList();
	}

	self.helpAnsDetail = function(id) {
		self.help_ans_errors = Constants.FALSE;

		$scope.ui_block();

		ManageTeacherTipsService.helpAnsDetail(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.help_ans_errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.help_ans_record = {};
					var help_ans_record = response.data;
					self.help_ans_record.id = help_ans_record.id;
					self.help_ans_record.status = help_ans_record.status;
					self.help_ans_record.subject = help_ans_record.subject;
					self.help_ans_record.subject_area = help_ans_record.subject_area;
					self.help_ans_record.module = help_ans_record.module;
					self.help_ans_record.created_at = help_ans_record.help_request.created_at;
					self.help_ans_record.title = help_ans_record.help_request.title;
					self.help_ans_record.content = help_ans_record.content;
					self.help_ans_record.created_by = help_ans_record.user.name;

				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.help_errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.saveEditHelpAns = function() {
		self.help_ans_errors = Constants.FALSE;
		self.help_ans_success = Constants.FALSE;

		$scope.ui_block();
		ManageTeacherTipsService.saveEditHelpAns(self.help_ans_record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors){
					self.help_ans_errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.help_ans_success = TeacherConstant.SUCCESS_EDIT_HELP_ANS;
					self.setHelpAnsActive('view', self.help_ans_record.id);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.help_errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.updateHelpAns = function(id, status) {
		self.help_ans_success = Constants.FALSE;
		self.help_ans_errors = Constants.FALSE;
		self.u_tip_status = (status == 1) ? Constants.ACCEPTED:Constants.REJECTED;

		$scope.ui_block();

		ManageTeacherTipsService.updateHelpAns(id, self.u_tip_status).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.help_ans_errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.help_ans_success = (status == 1) ? TeacherConstant.APPROVE_HELP_ANS:TeacherConstant.REJECT_HELP_ANS;
					self.setHelpAnsActive('list');
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			$scope.internalError();
			$scope.ui_unblock();
		});
	}

}