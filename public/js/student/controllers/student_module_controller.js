angular.module('futureed.controllers')
	.controller('StudentModuleController', StudentModuleController);

StudentModuleController.$inject = ['$scope', 'apiService', 'StudentModuleService'];

function StudentModuleController($scope, apiService, StudentModuleService) {
	var self = this;

	self.add = {};

	self.setTabActive = function(view) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.current_view = view;
	}

	self.toggleBtn = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.toggle_bottom = !self.toggle_bottom;
		self.setTipActive();
	}

	self.toggleBtnHelp = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.toggle_help_bottom = !self.toggle_help_bottom;
		self.setHelpActive();
	}

	self.giveTip = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.toggle_bottom = !self.toggle_bottom;
		self.setTipActive('add');
	}

	self.askHelp = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.toggle_help_bottom = !self.toggle_help_bottom;
		self.setHelpActive('add');
	}

	self.setHelpActive = function(active, id) {
		self.active_help_list = Constants.FALSE;
		self.active_help_add = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_ADD:
				self.active_help_add = Constants.TRUE;
				break;

			default:
				self.active_help_list = Constants.TRUE;
				break;
		}
	}

	self.addHelp = function() {
		// temprary declare ID's
		self.add.module_id = parseInt(1);
		self.add.subject_id = parseInt(1);
		self.add.link_id = parseInt(1);
		self.add.link_type = 'Question';
		self.add.class_id = $scope.user.class.id;
		self.add.student_id = $scope.user.id;

		$scope.ui_block();
		StudentModuleService.addHelp(self.add).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.success = Constants.FALSE;
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = Constants.TRUE;
					self.errors = Constants.FALSE;
					self.add = {};
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.setCurrentActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_current_list = Constants.FALSE;
		self.active_current_view = Constants.FALSE;

		switch(active){
			case Constants.ACTIVE_VIEW:
				self.active_current_view = Constants.TRUE;
				self.answer = {};
				self.getHelpDetails(id);
				break;
			default:
				self.active_current_list = Constants.TRUE;
				self.currentList();
				break;
		}
	}

	self.currentList = function(){
		// setting temporary request id
		self.request = {};
		self.request.student_id = $scope.user.id;
		self.request.module_id = 1;
		self.request.link_type = 'Content';
		self.request.help_request_type = studentModule.OTHERS;
		self.request.question_status = 'Open'
		self.request.link_id = 1;

		$scope.ui_block();
		StudentModuleService.list(self.request).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.records = {};
					self.records = response.data.records;

					angular.forEach(self.records, function(value, key) {
						value.created_at = moment(value.created_at).startOf("minute").fromNow();
					});
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getHelpDetails = function(id) {
		$scope.ui_block();
		StudentModuleService.getHelpDetails(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.details = {};
					var details = response.data;
					self.details.created_at = moment(details.created_at).startOf("minute").fromNow();
					self.details.name = details.student.first_name + ' ' + details.student.last_name;
					self.details.title = details.title;
					self.details.subject_area_name = (details.subject_area) ? details.subject_area.name:Constants.EMPTY_STR;
					self.details.subject_name = (details.subject) ? details.subject.name:Constants.EMPTY_STR;
					self.details.content = details.content;
					self.details.id = details.id;
					self.details.question_status = details.question_status;
					self.details.stars = new Array(5);
					if(self.details.question_status == Constants.ANSWERED){
						self.hide = Constants.TRUE;
					}
					self.getHelpAnswer(self.details.id);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getHelpAnswer = function(id) {
		self.answer_status = Constants.ACCEPTED;
		StudentModuleService.getHelpAnswer(id, self.answer_status).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.ans_record = response.data.records;
				}
			}
		}).error(function(response){	
			self.errors = $scope.internalError();
		});
	}

	self.submitAnswer = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.answer.student_id = $scope.user.id;
		self.answer.help_request_id = self.details.id;

		$scope.ui_block();
		StudentModuleService.submitAnswer(self.answer).success(function(response){
			if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = studentModule.ADD_ANSWER_SUCCESS;
					self.answer = {};
					self.getHelpAnswer(self.details.id);
				}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.setOwnActive = function(active, id, flag) {
		self.errors = Constants.FALSE;
		if(flag != 1){
			self.success = Constants.FALSE;
		}

		self.active_own_list = Constants.FALSE;
		self.active_own_view = Constants.FALSE;

		switch(active){
			case Constants.ACTIVE_VIEW:
				self.active_own_view = Constants.TRUE;
				self.answer = {};
				self.getHelpDetails(id);
				break;
			default:
				self.active_own_list = Constants.TRUE;
				self.ownList();
				break;
		}
	}

	self.ownList = function() {
		// setting temporary request id
		self.request = {};
		self.request.student_id = $scope.user.id;
		self.request.module_id = 1;
		self.request.link_type = 'Content';
		self.request.help_request_type = studentModule.OWN;
		self.request.question_status = 'Open,Answered'
		self.request.link_id = 1;

		$scope.ui_block();
		StudentModuleService.list(self.request).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.own_records = {};
					self.own_records = response.data.records;

					angular.forEach(self.own_records, function(value, key) {
						value.created_at = moment(value.created_at).startOf("minute").fromNow();
					});
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.updateHelp = function(id, flag) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.question_status = (flag == 1) ? studentModule.CANCEL : studentModule.CLOSE;

		$scope.ui_block();
		StudentModuleService.updateHelp(id, self.question_status).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = (flag == 1) ? studentModule.THREAD_DELETED: studentModule.THREAD_CLOSED;
					if(flag == 1) {
						self.setOwnActive('', '', 1)
					}else {
						self.hide = Constants.TRUE;
						self.getHelpDetails(id);
					}
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})

	}

	self.setTipActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_tip_add = Constants.FALSE;
		self.active_tip_list = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_ADD :
				self.active_tip_add = Constants.TRUE;
				break;
			default:
				self.active_tip_list = Constants.TRUE;
				break;
		}
	}

	self.addTip = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		/*Setting temporary params*/
		self.add.module_id = parseInt(1);
		self.add.subject_id = parseInt(1);
		self.add.subject_area_id = parseInt(1);
		self.add.link_type = "Content"
		self.add.link_id = parseInt(1);
		self.add.class_id = $scope.user.class.id;
		self.add.student_id = $scope.user.id;

		$scope.ui_block();
		StudentModuleService.addTip(self.add).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.success = Constants.FALSE;
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.success = Constants.TRUE;
					self.errors = Constants.FALSE;
					self.add = {};
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.tipList = function(limit, view, flag) {
		self.filters = {};
		/*setting temp params*/
		self.filters.module_id = parseInt(1);
		self.filters.link_id = (view == Constants.ALL) ? Constants.EMPTY_STR:parseInt(1);
		self.filters.link_type = "Content";
		self.filters.limit = (limit == 3) ? 3:0;

		$scope.ui_block();
		StudentModuleService.tipList(self.filters).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors){
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.tip_records = {};
					self.tip_records = response.data.records;

					angular.forEach(self.tip_records, function(value, key) {
						value.created_at = moment(value.created_at).startOf("minute").fromNow();
					});

					self.show_btn = (self.tip_records.length <= 3 || flag == 1) ? self.show_btn = Constants.TRUE:self.show_btn = Constants.FALSE;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.setCurrentActiveTip = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.active_current_tip_view = Constants.FALSE;
		self.actuve_current_tip_list = Constants.FALSE;

		switch (active) {
			case Constants.ACTIVE_VIEW :
				self.active_current_tip_view = Constants.TRUE;
				break;
			default :
				self.active_current_tip_list = Constants.TRUE;
				self.tipList(3, Constants.CURRENT);
				break;
		}
	}

	self.setAllActiveTip = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.active_current_tip_view = Constants.FALSE;
		self.actuve_current_tip_list = Constants.FALSE;

		switch (active) {
			case Constants.ACTIVE_VIEW :
				self.active_current_tip_view = Constants.TRUE;
				break;
			default :
				self.active_all_tip_list = Constants.TRUE;
				self.tipList(3, Constants.ALL);
				break;
		}
	}
}