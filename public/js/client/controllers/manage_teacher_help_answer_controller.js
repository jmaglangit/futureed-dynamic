angular.module('futureed.controllers')
	.controller('ManageTeacherHelpAnswerController', ManageTeacherHelpAnswerController);

ManageTeacherHelpAnswerController.$inject = ['$scope', 'ManageTeacherAnswerService', 'TableService', 'SearchService'];

function ManageTeacherHelpAnswerController($scope, ManageTeacherAnswerService, TableService, SearchService) {
	var self = this;

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setActive = function(active, id , flag) {
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
			self.listAnswers();
		}
	}

	self.listAnswers = function() {
		self.errors = Constants.FALSE;
		self.records = [];
		self.search.class_id = $scope.classid;
		self.table.loading = Constants.TRUE;

		$scope.ui_block();
		ManageTeacherAnswerService.listAnswer(self.search, self.table).success(function(response) {
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
		self.record = {};

		$scope.ui_block();
		ManageTeacherAnswerService.detail(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					var record = response.data;

					self.record.id = record.id;
					self.record.link_type = record.help_request.link_type;
					self.record.subject = (record.subject) ? record.subject.name : Constants.EMPTY_STR;
					self.record.subject_area = (record.subject_area) ? record.subject_area.name : Constants.EMPTY_STR;
					self.record.module = (record.module) ? record.module.name : Constants.EMPTY_STR;
					
					self.record.title = record.help_request.title;
					self.record.created_at = record.help_request.created_at;

					self.record.content = record.content;
					self.record.request_answer_status = record.request_answer_status;
					self.record.created_by = record.user.name;
					self.record.status = record.status;
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

		$scope.ui_block();
		ManageTeacherAnswerService.update(self.record).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
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

	self.rateAnswer = function() {
		self.rate_answer = Constants.TRUE;
		$("#rate_answer").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.updateStatus = function(id, status) {
		self.success = Constants.FALSE;
		self.errors = Constants.FALSE;
		self.rate = {};
		var answer_status = (status) ? Constants.ACCEPTED : Constants.REJECTED;
		self.rate.id = id;
		self.rate.request_answer_status = answer_status;
		self.rate.rated_by = Constants.TEACHER;
		self.rate.rating = self.rating;
		$scope.ui_block();
		ManageTeacherAnswerService.updateStatus(self.rate).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.rate_errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					$("#rate_answer").modal('hide');
					self.success = (status) ? TeacherConstant.APPROVE_HELP_ANS : TeacherConstant.REJECT_HELP_ANS;
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