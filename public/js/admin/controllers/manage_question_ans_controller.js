angular.module('futureed.controllers')
    .controller('ManageQuestionAnsController', ManageQuestionAnsController);

ManageQuestionAnsController.$inject = ['$scope', '$timeout', 'ManageQuestionAnsService', 'apiService', 'TableService', 'SearchService'];

function ManageQuestionAnsController($scope, $timeout, ManageQuestionAnsService, apiService, TableService, SearchService) {
    var self = this;

    self.details = {};
    self.delete = {};
    self.answers = {};

    TableService(self);
    self.tableDefaults();

    SearchService(self);
    self.searchDefaults();

    self.setModule = function(data) {
        self.module = data;
        self.module.id = data.id;
    }

    self.setActive = function(active, id, flag) {
        self.errors = Constants.FALSE;
        self.create = {};
        self.area_field = Constants.FALSE;

        self.active_list = Constants.FALSE;
        self.active_view = Constants.FALSE;
        self.active_add = Constants.FALSE;
        self.active_edit = Constants.FALSE;
        self.edit = Constants.FALSE;

        if(flag != 1) {
            self.success = Constants.FALSE;
        }

        switch (active) {
            case Constants.ACTIVE_EDIT:
                self.active_edit = Constants.TRUE;
                self.getQuestionDetail(id);
                self.edit = Constants.TRUE;
                self.success = Constants.FALSE;
                break;

            case Constants.ACTIVE_VIEW :
                self.active_view = Constants.TRUE;
                self.getQuestionDetail(id);
                break;

            case Constants.ACTIVE_ADD : 
                self.active_add = Constants.TRUE;
                break;

            default:
                self.active_list = Constants.TRUE;
                self.list();
                break;
        }
    }

    self.searchFnc = function(event) {
        self.errors = Constants.FALSE;
        self.list();
        
        event = getEvent(event);
        event.preventDefault();
    }

    self.clearFnc = function() {
        self.errors = Constants.FALSE;
        self.searchDefaults();
        self.list();
    }

    self.list = function() {
        var id = self.module.id;
        self.errors = Constants.FALSE;
        self.q_records = {};
        $scope.ui_block();
        ManageQuestionAnsService.list(id, self.search, self.table).success(function(response){
            if(angular.equals(response.status, Constants.STATUS_OK)){
                if(response.errors) {
                    self.errors = $scope.errorHandler(response.errors);
                }else if(response.data){
                    self.qa_records = response.data.records;
                }
            }
            $scope.ui_unblock();
        }).error(function(response){
            self.errors = $scope.internalError();
            $scope.ui_unblock();
        });
    }

    self.addNewQuestion = function() {
    	self.errors = Constants.FALSE;
		self.create.success = Constants.FALSE;
		self.fields = [];
		// set temporary seq_no (this will be remove once api will not require seq_no)
		self.create.seq_no = 1;
		self.create.module_id = self.module.id;

		$scope.ui_block();
		ManageQuestionAnsService.addNewQuestion(self.create).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.create = {};
					self.create.success = Constants.TRUE;
				}
			}
		$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
    }

    self.getQuestionDetail = function(id) {
    	self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageQuestionAnsService.getQuestionDetail(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.details = response.data;
				}
			}
		$scope.ui_unblock();
		}).error(function(response) {
			self.errors = internalError();
			$scope.ui_unblock();
		});
    }

    self.saveEditQuestion = function(){
		self.errors = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageQuestionAnsService.saveEditQuestion(self.details).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.validation = {};
					self.success = ManageModuleConstants.SUCCESS_EDIT_QUESTION;
					self.setActive('view', self.details.id, 1);
				}
			}
		$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.confirmDelete = function(id) {
		self.errors = Constants.FALSE;
		self.delete.id = id;
		self.delete.confirm = Constants.TRUE;

		$("#delete_question_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.deleteQuestion = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageQuestionAnsService.deleteQuestion(self.delete.id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.success = ManageModuleConstants.SUCCESS_DELETE_QUESTION;
					self.setActive('', '', 1);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.setAnsActive = function(active, id, flag) {
        self.answers.errors = Constants.FALSE
        self.area_field = Constants.FALSE;

        self.active_anslist = Constants.FALSE;
        self.active_ansedit = Constants.FALSE;
        self.edit = Constants.FALSE;

        if(flag != 1) {
            self.answers.success = Constants.FALSE;
        }

        switch (active) {
            case Constants.ACTIVE_EDIT:
                self.active_ansedit = Constants.TRUE;
                self.getAnswerDetail(id);
                self.answers.success = Constants.FALSE;
                break;

            default:
                self.active_anslist = Constants.TRUE;
                self.answerList();
                break;
        }
    }

	self.addAnswer = function() {
    	self.answers.errors = Constants.FALSE;
		self.answers.success = Constants.FALSE;
		self.fields = [];
		self.answers.module_id = self.module.id;
		self.answers.question_id = self.details.id;
		$scope.ui_block();
		ManageQuestionAnsService.addAnswer(self.answers).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.answers.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field + '_ans'] = Constants.TRUE;
					});
				} else if(response.data) {
					self.answers = {};
					self.answers.success = ManageModuleConstants.SUCCESS_ADD_ANSWER;
				}
			}
		$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.answerList = function(flag) {
		if(flag != 1){
			self.errors = Constants.FALSE;
		}
		var id = self.details.id;
		self.ans_records = {};

		$scope.ui_block();
		ManageQuestionAnsService.answerList(id).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.answers.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.ans_records = response.data.records;
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.confirmAnsDelete = function(id) {
		self.errors = Constants.FALSE;
		self.delete.ans_id = id;
		self.delete.ans_confirm = Constants.TRUE;

		$("#delete_answer_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.deleteAnswer = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		$scope.ui_block();
		ManageQuestionAnsService.deleteAnswer(self.delete.ans_id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.answers.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.answers.success = ManageModuleConstants.SUCCESS_DELETE_ANS;
					self.answerList(1);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.getAnswerDetail = function(id) {
		self.answers.errors = Constants.FALSE;

		$scope.ui_block();
		ManageQuestionAnsService.getQuestionDetail(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.answers.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.ansdetails = response.data;
				}
			}
		$scope.ui_unblock();
		}).error(function(response) {
			self.errors = internalError();
			$scope.ui_unblock();
		});
	}

	self.saveAnswer = function(){
		self.answers.errors = Constants.FALSE;
		self.fields = [];

		$scope.ui_block();
		ManageQuestionAnsService.saveAnswer(self.ansdetails).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.answrs.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field + '_ans'] = Constants.TRUE;
					});
				} else if(response.data) {
					self.answers.success = ManageModuleConstants.SUCCESS_EDIT_ANS;
					self.setAnsActive('list', '' , 1);
				}
			}
		$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}
}