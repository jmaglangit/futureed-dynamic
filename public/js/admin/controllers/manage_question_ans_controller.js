angular.module('futureed.controllers')
	.controller('ManageQuestionAnsController', ManageQuestionAnsController);

ManageQuestionAnsController.$inject = ['$scope', 'ManageQuestionAnsService', 'TableService', 'SearchService', 'Upload'];

function ManageQuestionAnsController($scope, ManageQuestionAnsService, TableService, SearchService, Upload) {
	var self = this;

	self.answers = {};

	TableService(self);
	self.tableDefaults();

	SearchService(self);
	self.searchDefaults();

	self.setModule = function(data) {
		self.module = data;
		self.module.id = data.id;
	}

	self.upload = function(file, object) {
		object.uploaded = Constants.FALSE;

		if(file.length) {
			$scope.ui_block();
			Upload.upload({
				url: '/api/v1/question/upload-image'
				, file: file[0]
			}).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					}else if(response.data){
						object.image = response.data.image_name;
						object.uploaded = Constants.TRUE;
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		}
	}

	self.uploadAnswer = function(file, object) {
		object.uploaded = Constants.FALSE;

		if(file.length) {
			$scope.ui_block();
			Upload.upload({
				url: '/api/v1/question/answer/upload-image'
				, file: file[0]
			}).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					}else if(response.data){
						object.answer_image = "/uploads/temp/answer/" + response.data.image_name;
						object.image = response.data.image_name;
						object.uploaded = Constants.TRUE;
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		}
	}

	self.uploadGraphImage = function(file, object) {
		object.uploaded = Constants.FALSE;

		if(file.length) {
			$scope.ui_block();
			Upload.upload({
				url: '/api/v1/question/answer-graph/upload-image'
				, file: file[0]
			}).success(function(response) {
				if(angular.equals(response.status, Constants.STATUS_OK)) {
					if(response.errors) {
						self.errors = $scope.errorHandler(response.errors);
					}else if(response.data){
						object.answer_image = "/uploads/temp/question/" + response.data.image_name;
						object.image = response.data.image_name;
						object.uploaded = Constants.TRUE;
					}
				}

				$scope.ui_unblock();
			}).error(function(response) {
				self.errors = $scope.internalError();
				$scope.ui_unblock();
			});
		}
	}

	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		
		self.fields = [];
		self.record = {};

		self.active_list = Constants.FALSE;
		self.active_view = Constants.FALSE;
		self.active_add = Constants.FALSE;
		self.active_edit = Constants.FALSE;

		switch (active) {
			case Constants.ACTIVE_EDIT:
				self.active_edit = Constants.TRUE;
				self.details(id);
				break;

			case Constants.ACTIVE_VIEW :
				self.active_view = Constants.TRUE;
				self.details(id);
				break;

			case Constants.ACTIVE_ADD : 
				self.active_add = Constants.TRUE;
				break;

			case Constants.ACTIVE_LIST : 
			default:
				self.active_list = Constants.TRUE;
				self.list();
				break;
		}

		$("html, body").animate({ scrollTop: 0 }, "slow");
	}

	self.searchFnc = function(event) {
		self.errors = Constants.FALSE;
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
		self.list();
	}

	self.list = function() {
		if(self.active_list) {
			self.questionList();
		}else if(self.active_view) {
			self.listAnswer();
		}
	}

	self.questionList = function() {
		self.errors = Constants.FALSE;
		self.records = [];
		
		self.table.loading = Constants.TRUE;
		self.search.module_id = self.module.id;

		$scope.ui_block();
		ManageQuestionAnsService.list(self.search, self.table).success(function(response){
			self.table.loading = Constants.FALSE;

			if(angular.equals(response.status, Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				}else if(response.data){
					self.records = response.data.records;
					self.updatePageCount(response.data);
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			self.table.loading = Constants.FALSE;
			$scope.ui_unblock();
		});
	}

	self.add = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		
		self.fields = [];
		self.record.module_id = self.module.id;

		$scope.ui_block();
		ManageQuestionAnsService.add(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, key) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_ADD);
					self.success = Constants.MSG_CREATED("Question");
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.details = function(id) {
		self.errors = Constants.FALSE;

		$scope.ui_block();
		ManageQuestionAnsService.details(id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.record = response.data;
				}
			}
			
			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = internalError();
			$scope.ui_unblock();
		});
	}

	self.removeImage = function(object) {
		// In add question 
		self.view_image = {};

		object.image = Constants.EMPTY_STR;
		object.image_path = Constants.EMPTY_STR;
		object.uploaded = Constants.FALSE;
	} 

	self.viewImage = function(object) {
		self.view_image = {};

		if(object.image) {
			self.view_image.image_path = "/uploads/temp/question/" + object.image;
		} else if(object.questions_image) {
			self.view_image.image_path = object.questions_image;
		}

		self.view_image.questions_text = (object.questions_text) ? object.questions_text : Constants.QUESTION ;
		self.view_image.show = Constants.TRUE;

		$("#qa_image_modal").modal({
			backdrop: 'static',
			keyboard: Constants.FALSE,
			show    : Constants.TRUE
		});
	}

	self.viewAnswerImage = function(object) {
		self.view_image = {};

		if(object.answer_image) {
			self.view_image.image_path = object.answer_image;
		} else if(object.questions_image) {
			self.view_image.image_path = object.answer_image;
		}

		self.view_image.questions_text = (object.answer_text) ? object.answer_text : Constants.ANSWER ;
		self.view_image.show = Constants.TRUE;

		$("#qa_image_modal").modal({
			backdrop: 'static',
			keyboard: Constants.FALSE,
			show    : Constants.TRUE
		});
	}

	self.update = function(){
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.fields = [];

		$scope.ui_block();
		ManageQuestionAnsService.update(self.record).success(function(response){
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);

					angular.forEach(response.errors, function(value, a) {
						self.fields[value.field] = Constants.TRUE;
					});
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_VIEW, self.record.id);
					self.success = Constants.MSG_UPDATED("Question");
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
		self.success = Constants.FALSE;

		self.record = {};
		self.record.id = id;
		self.record.confirm = Constants.TRUE;

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
		ManageQuestionAnsService.deleteQuestion(self.record.id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.setActive(Constants.ACTIVE_LIST);
					self.success = Constants.MSG_DELETED("Question");
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	/**
	* Functions for manage question answer (MC)
	*/
	self.setAnsActive = function(active, id) {
		self.answers.errors = Constants.FALSE;
		self.answers.success = Constants.FALSE;

		self.fields = [];
		self.answers.record = {};

		self.active_anslist = Constants.FALSE;
		self.active_ansedit = Constants.FALSE;

		switch (active) {
			case Constants.ACTIVE_EDIT:
				self.active_ansedit = Constants.TRUE;
				self.answerDetails(id);
				break;
 
			default:
				self.active_anslist = Constants.TRUE;
				self.listAnswer();
				break;
		}
	}

	self.clearAnswer = function() {
		self.setAnsActive();
	}

	self.addAnswer = function() {
		self.answers.errors = Constants.FALSE;
		self.answers.success = Constants.FALSE;
		self.fields = [];

		switch(self.record.question_type) {
			case Constants.GRAPH:
				answer_array = JSON.parse(self.record.answer);

				obj = {
					"field" : self.answers.record.field
					, "count" : parseInt(self.answers.record.count)
					, "count_objects" : parseInt(self.answers.record.count)
					, "image" : self.answers.record.answer_image
				}

				answer_array.answer.push(obj);

				data = {"question_type" : self.record.question_type, "answer" : JSON.stringify(answer_array)};

				ManageQuestionAnsService.addAnswerGraph(self.record.id, data).success(function(response){
					if(angular.equals(response.status, Constants.STATUS_OK)) {
						if(response.errors) {
							self.answers.errors = $scope.errorHandler(response.errors, Constants.TRUE);

							angular.forEach(response.errors, function(value, a) {
								self.fields[value.field + '_ans'] = Constants.TRUE;
							});

						} else if(response.data) {
							self.listAnswer();
							self.setAnsActive();
							self.answers.success = Constants.MSG_CREATED("Answer");
						}
					}
					$scope.ui_unblock();

				}).error(function(response){
					self.errors = $scope.internalError();
					$scope.ui_unblock();
				})

				break;

			default:
				self.answers.record.module_id = self.module.id;
				self.answers.record.question_id = self.record.id;

				$scope.ui_block();
				ManageQuestionAnsService.addAnswer(self.answers.record).success(function(response){
					if(angular.equals(response.status, Constants.STATUS_OK)) {
						if(response.errors) {
							self.answers.errors = $scope.errorHandler(response.errors, Constants.TRUE);

							angular.forEach(response.errors, function(value, a) {
								self.fields[value.field + '_ans'] = Constants.TRUE;
							});

						} else if(response.data) {
							self.setAnsActive();
							self.answers.success = Constants.MSG_CREATED("Answer");
						}
					}
					$scope.ui_unblock();
				}).error(function(response){
					self.errors = $scope.internalError();
					$scope.ui_unblock();
				})

				break;
		}


		
	}

	self.listAnswer = function() {
		self.answers.errors = Constants.FALSE;

		self.answers.records = [];
		self.table.loading = Constants.TRUE;

		switch(self.record.question_type) {
			case Constants.GRAPH:
				$scope.ui_block();
					ManageQuestionAnsService.listGraphAnswer(self.record.id).success(function(response) {
						self.table.loading = Constants.FALSE;

						if(angular.equals(response.status, Constants.STATUS_OK)){

							if(response.errors) {
								self.answers.errors = $scope.errorHandler(response.errors);
							}else if(response.data){
								self.answers.records = JSON.parse(response.data);
								self.updatePageCount(response.data);
							}
						}
						$scope.ui_unblock();
					}).error(function(response){
						self.answers.errors = $scope.internalError();
						self.table.loading = Constants.FALSE;
						$scope.ui_unblock();
					});
				break;

			default:
				$scope.ui_block();
					ManageQuestionAnsService.listAnswer(self.record.id).success(function(response) {
						self.table.loading = Constants.FALSE;

						if(angular.equals(response.status, Constants.STATUS_OK)){
							if(response.errors) {
								self.answers.errors = $scope.errorHandler(response.errors);
							}else if(response.data){
								self.answers.records = response.data.records;
								self.updatePageCount(response.data);
							}
						}
						$scope.ui_unblock();
					}).error(function(response){
						self.answers.errors = $scope.internalError();
						self.table.loading = Constants.FALSE;
						$scope.ui_unblock();
					});
				break;
		}
	}

	self.confirmAnsDelete = function(id) {
		self.answers.errors = Constants.FALSE;
		self.setAnsActive();

		self.delete = {};
		self.delete.ans_id = id;
		self.delete.ans_confirm = Constants.TRUE;

		$("#delete_answer_modal").modal({
			backdrop: 'static',
			keyboard: Constants.FALSE,
			show    : Constants.TRUE
		});
	}

	self.deleteAnswer = function() {
		self.answers.errors = Constants.FALSE;
		self.answers.success = Constants.FALSE;
		
		$scope.ui_block();
		ManageQuestionAnsService.deleteAnswer(self.delete.ans_id).success(function(response){
			if(angular.equals(response.status,Constants.STATUS_OK)){
				if(response.errors) {
					self.answers.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.setAnsActive();
					self.answers.success = Constants.MSG_DELETED("Answer");
				}
			}
			$scope.ui_unblock();
		}).error(function(response){
			self.answers.errors = $scope.internalError();
			$scope.ui_unblock();
		})
	}

	self.answerDetails = function(id) {
		self.answers.errors = Constants.FALSE;
		self.fields = [];

		switch(self.record.question_type) {
			case Constants.GRAPH:
				$scope.ui_block();
					ManageQuestionAnsService.listGraphAnswer(self.record.id).success(function(response) {
						if(angular.equals(response.status,Constants.STATUS_OK)){
							if(response.errors) {
								self.answers.errors = $scope.errorHandler(response.errors);
							} else if(response.data) {
								self.answers.record = JSON.parse(response.data).answer[id];
								self.answers.update_records = JSON.parse(response.data);
								self.answers.update_index = id;
							}
						}

						$scope.ui_unblock();
					}).error(function(response) {
						self.answers.errors = $scope.internalError();
						$scope.ui_unblock();
					});

				break;

			default:
				$scope.ui_block();
					ManageQuestionAnsService.answerDetails(id).success(function(response){
						if(angular.equals(response.status,Constants.STATUS_OK)){
							if(response.errors) {
								self.answers.errors = $scope.errorHandler(response.errors);
							} else if(response.data) {
								self.answers.record = response.data;
							}
						}

						$scope.ui_unblock();
					}).error(function(response) {
						self.answers.errors = $scope.internalError();
						$scope.ui_unblock();
					});
				break;
		}
	}

	self.updateAnswer = function(){
		self.answers.errors = Constants.FALSE;
		self.answers.success = Constants.FALSE;

		self.fields = [];

		switch(self.record.question_type) {
			case Constants.GRAPH:
					obj = {
						"field" : self.answers.record.field
						, "count" : parseInt(self.answers.record.count)
						, "count_objects" : parseInt(self.answers.record.count)
						, "image" : self.answers.record.uploaded == Constants.TRUE ? self.answers.record.answer_image : self.answers.record.image
					}

					self.answers.update_records.answer[self.answers.update_index] = obj;

					data = {"question_type" : self.record.question_type, "answer" : JSON.stringify(self.answers.update_records)};

					ManageQuestionAnsService.updateGraphAnswer(self.record.id, data).success(function(response){
						if(angular.equals(response.status, Constants.STATUS_OK)) {
							if(response.errors) {
								self.answers.errors = $scope.errorHandler(response.errors, Constants.TRUE);

								angular.forEach(response.errors, function(value, a) {
									self.fields[value.field + '_ans'] = Constants.TRUE;
								});

							} else if(response.data) {
								self.setAnsActive(Constants.ACTIVE_LIST);
								self.answers.success = Constants.MSG_UPDATED("Answer");
							}
						}
						$scope.ui_unblock();

					}).error(function(response){
						self.errors = $scope.internalError();
						$scope.ui_unblock();
					})
				break;

			default:
				$scope.ui_block();
					ManageQuestionAnsService.updateAnswer(self.answers.record).success(function(response){
						if(angular.equals(response.status, Constants.STATUS_OK)) {
							if(response.errors) {
								self.answers.errors = $scope.errorHandler(response.errors, Constants.TRUE);

								angular.forEach(response.errors, function(value, a) {
									self.fields[value.field + '_ans'] = Constants.TRUE;
								});
							} else if(response.data) {
								self.setAnsActive(Constants.ACTIVE_LIST);
								self.answers.success = Constants.MSG_UPDATED("Answer");
							}
						}

						$scope.ui_unblock();
					}).error(function(response){
						self.answers.errors = $scope.internalError();
						$scope.ui_unblock();
					})
				break;
		}
	}
}