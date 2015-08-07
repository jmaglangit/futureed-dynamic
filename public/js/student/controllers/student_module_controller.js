angular.module('futureed.controllers')
	.controller('StudentModuleController', StudentModuleController);

StudentModuleController.$inject = ['$scope', '$window', '$interval', '$filter', 'apiService', 'StudentModuleService', 'SearchService', 'TableService'];

function StudentModuleController($scope, $window, $interval, $filter, apiService, StudentModuleService, SearchService, TableService) {
	var self = this;

	SearchService(self);
	self.searchDefaults();

	TableService(self);
	self.tableDefaults();

	self.giveTip = function() {
		$scope.$broadcast('toggle-tips');
	}

	self.askHelp = function() {
		$scope.$broadcast('toggle-help');
	}

	/**
	* Functions related to module
	*/
	self.setActive = function(active, id) {
		self.errors = Constants.FALSE;

		self.active_questions = Constants.FALSE;
		self.active_contents = Constants.FALSE;
		self.result = Constants.FALSE;

		switch(active) {
			case Constants.ACTIVE_QUESTIONS 	:
				self.active_questions = Constants.TRUE;
				break;

			case Constants.ACTIVE_CONTENTS 	:

			default 		:
				self.active_contents = Constants.TRUE;
				break;
		}
	}

	/**
	* Updates Student Module
	*/
	var updateModuleStudent = function(data, successCallback) {
		$scope.ui_block();
		StudentModuleService.updateModuleStudent(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					if(successCallback) {
						successCallback(response);
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});	
	}

	var createModuleStudent = function(data, successCallback) {
		$scope.ui_block();
		StudentModuleService.createModuleStudent(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					if(successCallback) {
						successCallback(response);
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});	
	}


	self.launchModule = function(module_id) {
		// get module details
		self.getModuleDetail(module_id, function(response) {
			if(response.data) {
				self.record = response.data;
				
				if(!self.record.student_module.length) {
					// create student_module
					var data = {};
						data.class_id = $scope.user.class.class_id;
						data.student_id = $scope.user.id;
						data.module_id = self.record.id;

					createModuleStudent(data, function(response) {
						if(response.data) {
							self.record.student_module[0] = response.data;	
							loadModuleView();
						} else {
							self.errors = $internalError();
						}
					});
				} else {
					loadModuleView();
				}
			} else {
				self.errors = $scope.internalError();
			}
		});
	}

	var loadModuleView = function() {
		var student_module = self.record.student_module[0];
		self.getTeachingContents(student_module.module_id);
		self.setActive(Constants.ACTIVE_CONTENTS);
		return;

		// if last_answered_question_id value is 0, load contents
		if(!student_module.last_answered_question_id) {
			self.getTeachingContents(student_module.module_id);
			self.setActive(Constants.ACTIVE_CONTENTS);
		} else {
			// if last_answered_question_id value is > 0, load question
			self.setActive(Constants.ACTIVE_QUESTIONS);
			self.search.last_answered_question_id = student_module.last_answered_question_id;
			self.getModuleStudent(student_module.id, function(response) {
				var module_student = response.data;

				if(module_student.module_status == "Completed") {
					self.record.module_done = Constants.TRUE;
					self.errors = ["You have already completed this module."];
				} else {
					getAvatarPose($scope.user.avatar_id);
					listAvatarQuotes($scope.user.avatar_id);

					
					
					listQuestions(function(response) {
						angular.forEach(self.questions, function(value, key) {
							if(angular.equals(parseInt(value.id), parseInt(module_student.last_answered_question_id))) {
								self.current_question = value;
								self.current_question.answer_text = Constants.EMPTY_STR;
								self.current_question.answer_id = Constants.EMPTY_STR;

								self.question_counter = parseInt(module_student.question_counter) + 1;

								if(angular.equals(self.current_question.question_type, Constants.ORDERING)) {
									self.current_question.answer_text = self.current_question.question_order_text.split(",");
								}

								return;		
							}
						});
					});
				}
			});
		}
	}

	var getAvatarPose = function(avatar_id) {
		StudentModuleService.getAvatarPose(avatar_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.avatar_pose = response.data;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	var listAvatarQuotes = function(avatar_id) {
		StudentModuleService.listAvatarQuotes(avatar_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.avatar_quotes = response.data;
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	var listQuestions = function(successCallback) {
		self.errors = Constants.FALSE;

		self.search.module_id = self.record.id;

		$scope.ui_block();
		StudentModuleService.listQuestions(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					self.questions = response.data.records;
					if(successCallback) {
						successCallback(response);
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.exitModule = function() {
		var data = {};
			data.module_id = self.record.student_module[0].id;

			if(self.active_contents) {
				data.last_viewed_content_id = self.contents.content_id;
			}

			if(self.active_questions) {
				data.last_answered_question_id = self.questions.id;
			}
			
		updateModuleStudent(data, function() {
			var base_url = $("#base_url_form input[name='base_url']").val();
			$window.location.href = base_url +"/student/class";
		});
	}

	self.paginateContent = function() {
		// get next / prev content details
		// update student_module

		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		var page = self.table.page;

		self.table.page = (page < Constants.DEFAULT_PAGE) ? Constants.DEFAULT_PAGE : page;
		self.table.offset = (page - 1) * self.table.size;
		self.getTeachingContents(self.search.module_id);

	}

	self.startQuestions = function(object) {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;

		self.module_message = {};
		self.module_message.show = Constants.TRUE;
		self.module_message.name = self.record.name;
		self.module_message.points_earned = self.record.points_earned;
		self.module_message.badge_to_earn = self.record.badge_to_earn;
		self.module_message.skip_module = Constants.TRUE;

		$("#message_modal").modal({
	        backdrop: 'static',
	        keyboard: Constants.FALSE,
	        show    : Constants.TRUE
	    });
	}

	self.skipModule = function() {
		// update current view
		self.setActive(Constants.ACTIVE_QUESTIONS);

		// get question list; offset to 0
		getAvatarPose($scope.user.avatar_id);
		listAvatarQuotes($scope.user.avatar_id);
		listQuestions(function(response) {
			if(self.record.student_module[0].last_answered_question_id) {
				angular.forEach(self.questions, function(value, key) {
					if(angular.equals(parseInt(self.record.student_module[0].last_answered_question_id), parseInt(value.id))) {
						self.current_question = self.questions[key];
						return;
					}
				});

			} else {
				self.current_question = self.questions[0];
			}

			self.question_counter = (self.record.student_module[0].question_counter) ? parseInt(self.record.student_module[0].question_counter) + 1 : 1;

			var data = {};
				data.module_id = self.record.student_module[0].id;
				data.last_answered_question_id = self.current_question.id;

			updateModuleStudent(data);
		});
	}


	self.getModuleDetail = function(id, successCallback) {
		$scope.ui_block();
		StudentModuleService.getModuleDetail(id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					if(successCallback) {
						successCallback(response);
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getTeachingContents = function(id) {
		self.search.module_id = id;
		self.table.size = 1;

		$scope.ui_block();
		StudentModuleService.getTeachingContents(self.search, self.table).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else {
					self.contents = response.data.records[0];
					self.updatePageCount(response.data);

					var data = {};
						data.module_id = self.record.student_module[0].id;

						if(self.active_contents) {
							data.last_viewed_content_id = self.contents.id;
						}

					updateModuleStudent(data);
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.getModuleStudent = function(module_id, successCallback) {
		$scope.ui_block();
		StudentModuleService.getModuleStudent(module_id).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(successCallback) {
						successCallback(response);
					}
				}
			}

			$scope.ui_unblock();
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.checkAnswer = function() {
		var answer = {};

		answer.student_module_id = self.record.student_module[0].id;
		answer.module_id = self.record.id;
		answer.seq_no = self.current_question.seq_no;
		answer.question_id = self.current_question.id;
		answer.answer_id = self.current_question.answer_id;
		answer.student_id = $scope.user.id;
		answer.date_start = new Date();
		answer.date_end = new Date();
		answer.answer_text = (angular.equals(self.current_question.question_type, Constants.ORDERING)) ? self.current_question.answer_text.join(",") : self.current_question.answer_text;		

		$scope.ui_block();
		StudentModuleService.answerQuestion(answer).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
					self.result = {};

					if(response.errors[0].error_code == 2056) {
						self.result.failed = Constants.TRUE;
					}

					$scope.ui_unblock();
				} else if(response.data) {
					// show message
					self.result = response.data;
					self.result.failed = Constants.FALSE;

					if(angular.equals(self.result.module_status, "Completed")) {
						// get points
						var data = $scope.user;
							data.points = parseInt(data.points) + parseInt(self.record.points_earned);

						apiService.updateUserSession(data).success(function(response) {
							$scope.getUserDetails();
						});


						var data = {};
							data.age_group = 1;
							data.module_id = self.record.id;
						getPointsEarned(data, function(response) {
							// save points
							var data = {};
								data.student_id = $scope.user.id;
								data.points_earned = self.record.points_earned;
								data.module_id = self.record.id;

							saveStudentPoints(data, function(response) {
								var avatar_id = $scope.user.avatar_id;

								// get wiki
								getWiki(avatar_id, function(response) {
									$scope.ui_unblock();

									var avatar_wiki = response.data[0];

									self.result = {};

									self.errors = Constants.FALSE;
									self.success = Constants.FALSE;

									self.module_message = {};
									self.module_message.points_earned = self.record.points_earned;
									self.module_message.show = Constants.TRUE;
									self.module_message.title = avatar_wiki.title;
									self.module_message.name = self.record.name;
									
									self.module_message.description_summary = avatar_wiki.description_summary;
									self.module_message.description_full = avatar_wiki.description_full;
									self.module_message.message = self.module_message.description_summary;

									self.module_message.image = avatar_wiki.image; // ok
									self.module_message.source = avatar_wiki.source;
									self.module_message.module_done = Constants.TRUE; // ok

									$("#message_modal").modal({
								        backdrop: 'static',
								        keyboard: Constants.FALSE,
								        show    : Constants.TRUE
								    });
								});
							});
						});
					} else if(angular.equals(self.result.module_status, "Failed")) {
						self.errors = ["You need to review the teaching content."];
						self.result.failed = Constants.TRUE;
						$scope.ui_unblock();
					} else {
						$scope.ui_unblock();

						// update student_module
						var data = {};
							data.module_id = self.result.id;
							data.last_answered_question_id = self.result.next_question;
				
							updateModuleStudent(data, function(response) {
								setAvatarQuote();
							});
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
			$scope.ui_unblock();
		});
	}

	self.viewMoreWikiMessage = function() {
		self.module_message.message = self.module_message.description_full;
		self.module_message.full_message = Constants.TRUE;
	}

	var getPointsEarned = function(data, successCallback) {
		StudentModuleService.getPointsEarned(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(successCallback) {
						successCallback(response);
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	var saveStudentPoints = function(data, successCallback) {
		StudentModuleService.saveStudentPoints(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(successCallback) {
						successCallback(response);
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	var getWiki = function(data, successCallback) {
		StudentModuleService.getWiki(data).success(function(response) {
			if(angular.equals(response.status, Constants.STATUS_OK)) {
				if(response.errors) {
					self.errors = $scope.errorHandler(response.errors);
				} else if(response.data) {
					if(successCallback) {
						successCallback(response);
					}
				}
			}
		}).error(function(response) {
			self.errors = $scope.internalError();
		});
	}

	var setAvatarQuote = function() {
		if(!((self.result.question_counter) % 5)) {
			// get quote
			var percentage = Math.floor((parseInt(self.result.correct_counter) / parseInt(self.result.question_counter)) * 100);
			var seq_no = Math.floor(parseInt(self.result.question_counter) / 5) % 6;
			var avatar_quote_sequence = (!seq_no) ? 6 : seq_no;

			var avatar_quote = self.avatar_quotes[avatar_quote_sequence];
			var avatar_quote_info = {};

			if(percentage < 20) {
				avatar_quote_info = avatar_quote[0];
			} else if(percentage >= 20 && percentage < 40) {
				avatar_quote_info = avatar_quote[20];
			} else if(percentage >= 40 && percentage < 60) {
				avatar_quote_info = avatar_quote[40];
			} else if(percentage >= 60 && percentage < 80) {
				avatar_quote_info = avatar_quote[60];
			} else if(percentage >= 80 && percentage < 100) {
				avatar_quote_info = avatar_quote[80];
			} else if(percentage >= 100) {
				avatar_quote_info = avatar_quote[100];
			} else {
				self.result.answered = Constants.TRUE;
			}

			// get pose
			var avatar_pose_id = avatar_quote_info.avatar_quote.avatar_pose_id;
			angular.forEach(self.avatar_pose, function(value, key) {
				if(angular.equals(parseInt(value.id), parseInt(avatar_pose_id))) {
					avatar_quote_info.avatar_pose = value;
					return;
				}
			});

			self.avatar_quote_info = avatar_quote_info;
			self.result.quoted = Constants.TRUE;
		} else {
			self.result.answered = Constants.TRUE;
		}

		self.result.points_earned = parseInt(self.result.points_earned);
	}

	self.selectAnswer = function(object) {
		self.current_question.answer_id = object.id;
	}

	self.nextQuestion = function() {
		self.errors = Constants.FALSE;
		self.success = Constants.FALSE;
		self.current_question = {};

		angular.forEach(self.questions, function(value, key) {
			if(angular.equals(parseInt(value.id), parseInt(self.result.next_question))) {
				self.current_question = value;
				self.current_question.answer_text = Constants.EMPTY_STR;
				self.current_question.answer_id = Constants.EMPTY_STR;

				if(angular.equals(self.current_question.question_type, Constants.ORDERING)) {
					self.current_question.answer_text = self.current_question.question_order_text.split(",");
				}

				self.question_counter = parseInt(self.result.question_counter) + 1;

				self.result = {};
				return;
			}
		});
	}

	self.updateBackground = function() {
		angular.element('body.student').css({
			'background-image' : 'url('+ $scope.user.background +')'
		});
	}

	self.dragControlListeners = {
	    accept: function (sourceItemHandleScope, destSortableScope) {
	    	return true;
	    }
	    , itemMoved: function (event) {
	    	
	    }
	    , orderChanged: function(event) {
	    	
	    }
	    , containment: '#board'//optional param.
	};

	self.reviewContent = function() {
		if(self.result && self.result.failed) {
			// create student_module
			var data = {};
				data.class_id = $scope.user.class.class_id;
				data.student_id = $scope.user.id;
				data.module_id = self.record.id;

			createModuleStudent(data, function(response) {
				if(response.data) {
					self.record.student_module[0] = response.data;	
					loadModuleView();
				} else {
					self.errors = $internalError();
				}
			});
		} else {
			self.launchModule(self.record.id);
		}
	}
}